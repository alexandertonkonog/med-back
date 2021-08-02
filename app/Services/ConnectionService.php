<? 

namespace App\Services;

use App\Models\Connection;
use App\Utils\RightHelper;
use App\Utils\FilterHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Filters\ConnectionFilter;

class ConnectionService {
    public function select($data) {
        $user = Auth::user();
        $withArray = FilterHelper::getRelationsArray($data);
        if ($user->type === 4) {
            $filter = app()->make(ConnectionFilter::class, ['queryParams' => array_filter($data)]);
            return Connection::with($withArray)->filter($filter)->get();
        } else {
            return Connection::with($withArray)->where('user_id', $user->id)->get();
        }
    }

    public function create($data) {
        DB::beginTransaction();
        try {
            $user = Auth::user();

            $hasPermission = RightHelper::check(1, 'connection');

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);

            $entityArray = [
                'type_id' => $data['type_id'],
                'login' => $data['login'] ?? null,
                'password' => $data['password'] ?? null,
                'duration' => $data['duration'] ?? null,
                'url' => $data['url'] ?? null,
                'props' => $data['props'] ?? null,
                'subtype_id' => $data['subtype_id'] ?? null,
                'user_id' => $user->type === 3 ? $user->parent_id : $user->id,
            ];

            $entity = Connection::create($entityArray);

            DB::commit();
            return Connection::with(['type'])->find($entity->id);

        } catch (\Exception $e) {

            DB::rollback();

            return response(['message' => $e->getMessage()], 500);

        }
        
    }

    public function update($data) {
        DB::beginTransaction();
        try {
            
            $id = (int) $data['id'];
            $entity = Connection::find($id);

            if (!$entity) {
                return response(['message' => 'There is not entity'], 400);
            }

            $hasPermission = RightHelper::check(1, 'connection', $entity);

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);
           
            if (isset($data['type_id'])) {
                $entity->type_id = $data['type_id'];
            }
            
            if (isset($data['subtype_id'])) {
                $entity->subtype_id = $data['subtype_id'];
            }
            
            if (isset($data['login'])) {
                $entity->login = $data['login'];
            }
            
            if (isset($data['password'])) {
                $entity->password = $data['password'];
            }
            
            if (isset($data['url'])) {
                $entity->url = $data['url'];
            }
            
            if (isset($data['props'])) {
                $entity->props = $data['props'];
            }
            
            if (isset($data['duration'])) {
                $entity->duration = $data['duration'];
            }

            $entity->save();

            DB::commit();
            return Connection::with(['type'])->find($entity->id);

        } catch (\Exception $e) {

            DB::rollback();

            return response(['message' => $e->getMessage()], 500);

        }
    }

    public function delete($data) {
        $id = (int) $data['id'];
        $entity = Connection::find($id);
        
        if ($entity) {
            $hasPermission = RightHelper::check(2, 'connection', $entity);

            if (!$hasPermission) return response(['message' => 'You don\'t have enough permissions'], 403);

            $entity->delete();
            return response(['message' => 'This entity has removed'] , 200);
        } else {
            return response(['message' => 'There is not entity'] , 400);
        }
    }
}