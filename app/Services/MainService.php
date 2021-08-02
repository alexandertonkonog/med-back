<? 

namespace App\Services;

use App\Models\Clinic;
use App\Utils\FileHelper;
use App\Utils\RightHelper;
use App\Utils\FilterHelper;
use Illuminate\Http\Request;
use App\Http\Filters\ClinicFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MainService {

    public function __construct(array $data) {
        $this->files = ['files', 'img'];
        $this->removeFiles = ['removeFiles'];
        $this->manyToMany = $data['attributes']['manyToMany'];
        $this->entity = $data['model'];
        $this->rightName = $data['rightName'];
        $this->filter = $data['filter'];
    }

    public function select(Request $request) {
        $data = $request->validated();
        $withArray = FilterHelper::getRelationsArray($data);
        $filter = app()->make($this->filter, ['queryParams' => array_filter($data)]);
        return $this->entity::with($withArray)->filter($filter)->get();
    }

    public function create(Request $request) {       
        DB::beginTransaction();
        $data = $request->validated();
        $helper = new FileHelper($data);

        try {
            $mappedData = $this->mapData($data);
            $user = Auth::user();
            $entityArray = ['user_id' => $user->type === 3 ? $user->parent_id : $user->id];
            
            $hasPermission = RightHelper::check(1, $this->rightName);

            if (!$hasPermission) {
                abort(403, 'You don\'t have enough permissions');
            };

            foreach($mappedData['default'] as $key => $value) {
                if (!empty($value)) {
                    $entityArray[$key] = $value;
                }
            }

            $entity = $this->entity::create($entityArray);            

            foreach($mappedData['manyToMany'] as $key => $value) {
                if (!empty($value)) {
                    $entity->$key()->attach($value);
                }
            }

            if (isset($data['img'])) {
                $entity->img()->create($helper->createFile());
            }

            if (isset($data['files'])) {
                $entity->files()->createMany($helper->saveRelationFiles());
            }

            DB::commit();

            return $this->entity::with('img', 'files')->find($entity->id);

        } catch (\Exception $e) {

            $helper->errorRemoveFiles();

            DB::rollback();

            return response(['message' => $e->getMessage()], 500);

        }
    }

    public function update(Request $request) {
        DB::beginTransaction();
        $data = $request->validated();
        $helper = new FileHelper($data);
        try {
            $id = (int) $data['id'];
            $mappedData = $this->mapData($data);
            $entity = $this->entity::find($id);
            
            if (!$entity) {
                abort(400, 'There is not entity');
            }

            $hasPermission = RightHelper::check(1, $this->rightName, $entity);

            if (!$hasPermission) {
                abort(403, 'You don\'t have enough permissions');
            };

            foreach($mappedData['default'] as $key => $value) {
                if (!empty($value)) {
                    $entity->$key = $value;
                }
            }

            $entity->save();

            foreach($mappedData['manyToMany'] as $key => $value) {
                if (!empty($value)) {
                    $entity->$key()->sync($value);
                }
            }

            if (isset($data['img'])) {
                $entity->img()->create($helper->updateFile($entity));
            }

            if (isset($data['files'])) {
                $entity->files()->createMany($helper->updateRelationFiles($entity));
            }

            DB::commit();
            return $this->entity::with('img', 'files')->find($entity->id);

        } catch (\Exception $e) {
            $helper->errorRemoveFiles();

            DB::rollback();

            return response(['message' => $e->getMessage()], $e->getStatusCode());
        }
    }

    public function delete(Request $request) {
        $data = $request->validated();
        $id = (int) $data['id'];
        $entity = $this->entity::find($id);
        $user = Auth::user();
        if ($entity) {
            $hasPermission = RightHelper::check(2, $this->rightName, $entity);

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);

            $entity->delete();
            return response(['message' => 'This entity has removed'] , 200);
        } else {
            return response(['message' => 'There is not entity'] , 400);
        }
    }

    private function mapData(array $data) {
        $result = [
            'default' => [],
            'manyToMany' => [],
        ];

        foreach($data as $key => $value) {
            if (in_array($key, $this->manyToMany)) {
                $result['manyToMany'][$key] = $value;
            } else if (!in_array($key, $this->files) && !in_array($key, $this->removeFiles)) {
                $result['default'][$key] = $value;
            }
        }

        return $result;
    }
}