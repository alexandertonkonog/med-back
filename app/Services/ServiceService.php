<? 

namespace App\Services;

use App\Models\Service;
use App\Utils\FileHelper;
use App\Utils\RightHelper;
use App\Utils\FilterHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Filters\ServiceFilter;
use Illuminate\Support\Facades\Auth;

class ServiceService {
    public function select($data) {
        $withArray = FilterHelper::getRelationsArray($data);
        $filter = app()->make(ServiceFilter::class, ['queryParams' => array_filter($data)]);
        return Service::with($withArray)->filter($filter)->get();
    }

    public function create($data) {
        DB::beginTransaction();
        $helper = new FileHelper($data);
        try {
            $user = Auth::user();

            $hasPermission = RightHelper::check(1, 'service');

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);

            $entityArray = [
                'name' => $data['name'],
                'external_id' => $data['external_id'] ?? null,
                'cost' => $data['cost'] ?? null,
                'duration' => $data['duration'] ?? null,
                'code' => $data['code'] ?? null,
                'user_id' => $user->type === 3 ? $user->parent_id : $user->id,
            ];

            $entity = Service::create($entityArray);

            if (isset($data['img'])) {
                $entity->img()->create($helper->createFile());
            }

            if (isset($data['specializations'])) {
                $entity->specializations()->attach($data['specializations']);
            }

            if (isset($data['doctors'])) {
                $entity->doctors()->attach($data['doctors']);
            }

            DB::commit();
            return Service::with(['doctors', 'specializations'])->find($entity->id);
        } catch (\Exception $e) {
            $helper->errorRemoveFiles();
            DB::rollback();
            return response(['message' => $e], 500);
        }
        
    }

    public function update($data) {
        DB::beginTransaction();
        $helper = new FileHelper($data);
        try {
            
            $id = (int) $data['id'];
            $entity = Service::find($id);

            if (!$entity) {
                return response(['message' => 'Нет такой услуги'], 400);
            }

            $hasPermission = RightHelper::check(1, 'service', $entity);

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);
           
            if (isset($data['external_id'])) {
                $entity->external_id = $data['external_id'];
            }
            
            if (isset($data['cost'])) {
                $entity->cost = $data['cost'];
            }
            
            if (isset($data['duration'])) {
                $entity->duration = $data['duration'];
            }
            
            if (isset($data['name'])) {
                $entity->name = $data['name'];
            }

            if (isset($data['code'])) {
                $entity->code = $data['code'];
            }
             
            $entity->save();
            
            if (isset($data['specializations'])) {
                $entity->specializations()->sync($data['specializations']);
            }
         
            if (isset($data['doctors'])) {
                $entity->doctors()->sync($data['doctors']);
            }

            if (isset($data['img'])) {
                $entity->img()->create($helper->updateFile($entity));
            }

            DB::commit();
            return Service::with(['doctors', 'specializations'])->find($entity->id);
        } catch (\Exception $e) {
            $helper->errorRemoveFiles();

            DB::rollback();
            return response(['message' => $e], 500);
        }
    }

    public function delete($data) {
        $id = (int) $data['id'];
        $entity = Service::find($id);
        
        if ($entity) {
            $hasPermission = RightHelper::check(2, 'service', $entity);

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);

            $entity->delete();
            return response(['message' => 'Услуга удалена'] , 200);
        } else {
            return response(['message' => 'Нет такой услуги'] , 400);
        }
    }
}