<?

namespace App\Utils;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class RightHelper {

    /**
     * Check user rights for action. If user hasn't rights it returns error
     *
     * @param int $action code of action (0 - read, 1 - write, 2 - remove, 3 - special)
     * 
     * @param string $name entity name
     * 
     * @param Model $entity checking entity 
     * 
     * @return void
     *
     */
    static public function check(int $action, string $name, Model $entity = null) {
        $user = Auth::user();
        $condition = true;
        
        $rightEntity = static::getRights($user);

        if (!$rightEntity) {
            $condition = false;
            return $condition;
        }

        $rights = $rightEntity->$name;

        if ($rights[$action] === '-') {
            $condition = false;
        }

        if ($entity && $user->parent_id !== $entity->user_id && $user->id !== $entity->user_id) {
            $condition = false;
        }
        
        return $condition;
    }

    static private function getRights(User $user) {
        $rightEntity = $user->rights;

        if (!$rightEntity) {
            $parent = $user->parent;
            if ($parent) {
                $rightEntity = $parent->rights;
                if (!$rightEntity) {
                    $rightEntity = $user->group->rights;
                }
            }
        }

        return $rightEntity;
    }
}