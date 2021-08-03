<? 

namespace App\Services;

use App\Utils\FileHelper;
use App\Utils\FilterHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MainService {

    public function __construct(array $data) {
        $this->files = ['files', 'img'];
        $this->removeFiles = ['removeFiles'];
        $this->manyToMany = $data['attributes']['manyToMany'];
        $this->entity = $data['model'];
        $this->rightName = $data['rightName'];
        $this->filter = $data['filter'];
        $this->checkSelect = $data['checkSelect'] ?? false;
    }

    public function select(Request $request) {
        if ($this->checkSelect) {
            // if (Gate::denies('check', [['action' => 0, 'name' => $this->rightName]])) {
            //     return response(['message' => 'You don\'t have enough permissions'], 403);
            // }
        }

        $data = $request->validated();
        $withArray = FilterHelper::getRelationsArray($data);
        $filter = app()->make($this->filter, ['queryParams' => array_filter($data)]);
        return $this->entity::with($withArray)->filter($filter)->paginate(10);
    }

    public function create(Request $request) { 

        if (Gate::denies('check', [['action' => 1, 'name' => $this->rightName]])) {
            return response(['message' => 'You don\'t have enough permissions'], 403);
        }     

        DB::beginTransaction();
        $data = $request->validated();
        $helper = new FileHelper($data);

        try {
            $mappedData = $this->mapData($data);
            $user = Auth::user();
            $entityArray = ['user_id' => $user->type === 3 ? $user->parent_id : $user->id];

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
        if (Gate::denies('check', [['action' => 1, 'name' => $this->rightName]])) {
            return response(['message' => 'You don\'t have enough permissions'], 403);
        }
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
        if ($entity) {
            if (Gate::denies('check', [['action' => 2, 'name' => $this->rightName, 'entity' => $entity]])) {
                return response(['message' => 'You don\'t have enough permissions'], 403);
            } 
            $entity->delete();
            return response(['message' => 'This entity has removed'] , 200);
        } else {
            return response(['message' => 'There is not entity'] , 400);
        }
    }

    protected function mapData(array $data) {
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