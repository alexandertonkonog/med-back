<?

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\MainService;

class ScheduleService extends MainService {

    public function select(Request $request) {
        $entities = parent::select($request);
        
        return $entities;
    }
    
}