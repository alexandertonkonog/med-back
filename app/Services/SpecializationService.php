<? 

namespace App\Services;

use App\Utils\RightHelper;
use App\Utils\FilterHelper;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Filters\SpecializationFilter;

class SpecializationService {
    public function select($data) {
        $withArray = FilterHelper::getRelationsArray($data);
        $filter = app()->make(SpecializationFilter::class, ['queryParams' => array_filter($data)]);
        return Specialization::with($withArray)->filter($filter)->get();
    }

    public function create($data) {
        DB::beginTransaction();
        try {
            $user = Auth::user();

            $hasPermission = RightHelper::check(1, 'service');

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);

            $entityArray = [
                'name' => $data['name'],
                'code' => $data['code'] ?? null,
                'external_id' => $data['external_id'] ?? null,
                'description' => $data['description'] ?? null,
                'user_id' => $user->type === 3 ? $user->parent_id : $user->id,
            ];

            $entity = Specialization::create($entityArray);

            if (isset($data['services'])) {
                $entity->services()->attach($data['services']);
            }

            if (isset($data['doctors'])) {
                $entity->doctors()->attach($data['doctors']);
            }

            DB::commit();
            return Specialization::with(['doctors', 'services'])->find($entity->id);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['message' => $e], 500);
        }
        
    }

    public function update($data) {
        DB::beginTransaction();
        try {
            
            $id = (int) $data['id'];
            $entity = Specialization::find($id);

            if (!$entity) {
                return response(['message' => 'Нет такой сущности'], 400);
            }

            $hasPermission = RightHelper::check(1, 'service', $entity);

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);
           
            if (isset($data['external_id'])) {
                $entity->external_id = $data['external_id'];
            }
            
            if (isset($data['description'])) {
                $entity->description = $data['description'];
            }
            
            if (isset($data['name'])) {
                $entity->name = $data['name'];
            }

            if (isset($data['code'])) {
                $entity->code = $data['code'];
            }
            
            if (isset($data['services'])) {
                $entity->services()->sync($data['services']);
            }
         
            if (isset($data['doctors'])) {
                $entity->doctors()->sync($data['doctors']);
            }

            $entity->save();

            DB::commit();
            return Specialization::with(['doctors', 'services'])->find($entity->id);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['message' => $e], 500);
        }
    }

    public function delete($data) {
        $id = (int) $data['id'];
        $entity = Specialization::find($id);
        if ($entity) {
            
            $hasPermission = RightHelper::check(2, 'service', $entity);

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);

            $entity->delete();
            return response(['message' => 'Сущность удалена'] , 200);
        } else {
            return response(['message' => 'Нет такой сущности'] , 400);
        }
    }
}