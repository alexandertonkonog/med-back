<? 

namespace App\Services;

use App\Models\Doctor;
use App\Utils\FileHelper;
use App\Utils\RightHelper;
use App\Utils\FilterHelper;
use App\Http\Filters\DoctorFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DoctorService {
    public function select($data) {
        $withArray = FilterHelper::getRelationsArray($data);
        $filter = app()->make(DoctorFilter::class, ['queryParams' => array_filter($data)]);
        return Doctor::with($withArray)->filter($filter)->get();
    }

    public function create($data) {
        DB::beginTransaction();
        $helper = new FileHelper($data);
        try {
            $user = Auth::user();

            $hasPermission = RightHelper::check(1, 'doctor');

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);

            $entityArray = [
                'name' => $data['name'],
                'external_id' => $data['external_id'] ?? null,
                'user_id' => $user->type === 3 ? $user->parent_id : $user->id,
            ];

            $entity = Doctor::create($entityArray);            

            if (isset($data['specializations'])) {
                $entity->specializations()->attach($data['specializations']);
            }

            if (isset($data['services'])) {
                $entity->services()->attach($data['services']);
            }

            if (isset($data['img'])) {
                $entity->img()->create($helper->createFile());
            }

            if (isset($data['files'])) {
                $entity->files()->createMany($helper->saveRelationFiles());
            }
            
            DB::commit();
            return Doctor::with(['services', 'specializations', 'files'])->find($entity->id);
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
            $entity = Doctor::find($id);

            if (!$entity) {
                return response(['message' => 'Нет такого доктора'], 400);
            }

            $hasPermission = RightHelper::check(1, 'doctor', $entity);

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);
            
           
            if (isset($data['external_id'])) {
                $entity->external_id = $data['external_id'];
            }
            
            if (isset($data['name'])) {
                $entity->name = $data['name'];
            }
            
            $entity->save();

            if (isset($data['specializations'])) {
                $entity->specializations()->sync($data['specializations']);
            }
         
            if (isset($data['services'])) {
                $entity->services()->sync($data['services']);
            }
            
            if (isset($data['img'])) {
                $entity->img()->create($helper->updateFile($entity));
            }

            if (isset($data['files'])) {
                $entity->files()->createMany($helper->updateRelationFiles($entity));
            }

            DB::commit();
            return Doctor::with(['services', 'specializations', 'files'])->find($entity->id);
        } catch (\Exception $e) {
            $helper->errorRemoveFiles();

            DB::rollback();
            return response(['message' => $e], 500);
        }
    }

    public function delete($data) {
        $id = (int) $data['id'];
        $entity = Doctor::find($id);

        if ($entity) {
            $hasPermission = RightHelper::check(2, 'doctor', $entity);

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);
            $entity->delete();
            return response(['message' => 'Доктор удален'] , 200);
        } else {
            return response(['message' => 'Нет такого доктора'] , 400);
        }
    }
}