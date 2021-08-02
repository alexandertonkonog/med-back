<? 

namespace App\Services;

use App\Models\Clinic;
use App\Utils\FilterHelper;
use App\Utils\FileHelper;
use App\Utils\RightHelper;
use App\Http\Filters\ClinicFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClinicService {
    public function select($data) {
        $withArray = FilterHelper::getRelationsArray($data);
        $filter = app()->make(ClinicFilter::class, ['queryParams' => array_filter($data)]);
        return Clinic::with($withArray)->filter($filter)->get();
    }

    public function create($data) {
        $helper = new FileHelper($data);
        
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $hasPermission = RightHelper::check(1, 'clinic');

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);

            $entityArray = [
                'name' => $data['name'],
                'external_id' => $data['external_id'] ?? null,
                'user_id' => $user->type === 3 ? $user->parent_id : $user->id,
            ];
            
            $entity = Clinic::create($entityArray);

            if (isset($data['img'])) {
                $entity->img()->create($helper->createFile());
            }

            if (isset($data['files'])) {
                $entity->files()->createMany($helper->saveRelationFiles());
            }

            DB::commit();
            return Clinic::with(['files', 'img'])->find($entity->id);

        } catch (\Exception $e) {

            $helper->errorRemoveFiles();

            DB::rollback();

            return response(['message' => $e->getMessage()], 500);

        }
        
    }

    public function update($data) {
        DB::beginTransaction();
        $helper = new FileHelper($data);
        try {
            $id = (int) $data['id'];
            $entity = Clinic::find($id);
            $hasPermission = RightHelper::check(1, 'clinic', $entity);

            if (!$entity) {
                return response(['message' => 'There is not entity'], 400);
            }

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);
            $entityArray = [];

            if (isset($data['name'])) {
                $entityArray['name'] = $data['name'];
            }

            if (isset($data['external_id'])) {
                $entityArray['external_id'] = $data['external_id'];
            }

            $entity->update($entityArray);

            if (isset($data['img'])) {
                $entity->img()->create($helper->updateFile($entity));
            }

            if (isset($data['files'])) {
                $entity->files()->createMany($helper->updateRelationFiles($entity));
            }

            DB::commit();
            return Clinic::with(['files', 'img'])->find($entity->id);

        } catch (\Exception $e) {
            $helper->errorRemoveFiles();

            DB::rollback();

            return response(['message' => $e->getMessage()], $e->getStatusCode());
        }
    }

    public function delete($data) {
        $id = (int) $data['id'];
        $entity = Clinic::find($id);
        $user = Auth::user();
        if ($entity) {
            $hasPermission = RightHelper::check(2, 'clinic', $entity);

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);

            $entity->delete();
            return response(['message' => 'This entity has removed'] , 200);
        } else {
            return response(['message' => 'There is not entity'] , 400);
        }
    }
}