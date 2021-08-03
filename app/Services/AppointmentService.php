<? 

namespace App\Services;

use App\Models\User;
use App\Utils\FileHelper;
use Illuminate\Http\Request;
use App\Services\MainService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AppointmentService extends MainService {

    public function create(Request $request) {
        if (Gate::denies('check', ['action' => 1, 'name' => $this->rightName])) {
            abort(403, 'You don\'t have enough permissions');
        } 
        DB::beginTransaction();
        $data = $request->validated();
        $helper = new FileHelper($data);
        try {
            $mappedData = $this->mapData($data);
            $user = null;
            if (isset($data['user_id'])) {
                $user = User::find($data['user_id']);
            } else {
                $user = Auth::user();
            }
            
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
    
}