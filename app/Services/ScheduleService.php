<?

namespace App\Services;

use App\Utils\FileHelper;
use Illuminate\Http\Request;
use App\Services\MainService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ScheduleService extends MainService {

    protected $start = null;
    protected $end = null;
    protected $checkDates = false;

    public function select(Request $request, $select = '*') {
        $entities = parent::select($request, $select);
        $this->getBorders($request);
        $result = [];
        foreach($entities as $entity) {
            $result[] = $this->formatSchedule($entity);
        }
        return $result;
    }

    public function find(Request $request, int $id, $select = '*') {
        $entity = parent::find($request, $id, $select);
        $this->getBorders($request);
        return $this->formatSchedule($entity);
    }

    public function create(Request $request) {
        if (Gate::denies('check', [['action' => 1, 'name' => $this->rightName]])) {
            return response(['message' => 'You don\'t have enough permissions'], 403);
        }     

        DB::beginTransaction();
        $data = $request->validated();
        $helper = new FileHelper($data);

        try {
            $user = Auth::user();
            $entityArray = [
                'user_id' => $user->id,
                'month' => $data['month'],
                'scheduleable_id' => $data['scheduleable_id'],
                'scheduleable_type' => $this->getType($data['scheduleable_id']),
                'type' => $data['type']
            ];

            if ($data['type'] === 1) {
                // [['date' => 0, 'start' => '0000-00-00T08:00:00', 'end' => '0000-00-00T17:00:00']] в date номер дня недели
                if (isset($data['format'])) {
                    $entityArray['format'] = $data['format'];
                } else {
                    return response(['message' => 'Format is required for this schedule type'], 400);
                }
                $entityArray['schedule'] = $this->getWeekSchedule($data);
            } else if ($data['type'] === 2) {
                $condition = false;
                // [['date' => 0, 'start' => '0000-00-00T08:00:00', 'end' => '0000-00-00T17:00:00']] в date порядковый номер рабочего дня
                if (isset($data['format'])) {
                    $entityArray['format'] = $data['format'];
                } else {
                    $condition = 'format';
                }

                if (isset($data['first_day'])) {
                    $entityArray['first_day'] = $data['first_day'];
                } else {
                    $condition = 'first_day';
                }

                $entityArray['schedule'] = $this->getShiftSchedule($data);
                
                if ($condition) {
                    return response(['message' => "$condition is required for this schedule type"], 400);
                }
            } else {
                //[['date' => '2021-01-01T08:00:00', 'start' => '0000-00-00T08:00:00', 'end' => '0000-00-00T17:00:00']]
                $entityArray['schedule'] = $data['schedule'];
            }

            $entity = $this->entity::create($entityArray);            

            DB::commit();

            return $this->entity::with('scheduleable')->find($entity->id);

        } catch (\Exception $e) {

            $helper->errorRemoveFiles();

            DB::rollback();

            return response(['message' => $e->getMessage()], 500);

        }
    }

    private function formatSchedule($elem) {
        $entity = json_decode((json_encode($elem)), true);
        $schedule = json_decode($entity['schedule'], true);
        $entity['schedule'] = $schedule;
        return $entity;
    }

    private function getBorders(Request $request) {
        $data = $request->validated();
        if (isset($data['start'])) {
            $this->start = $data['start'];
        }
        if (isset($data['end'])) {
            $this->end = $data['end'];
        }
        if ($this->start && $this->end) {
            $this->checkDates = true;
        }
    }
    
    private function getType($type) {
        switch ($type) {
            case 'doctor':
                return 'App\Models\Doctor';
            case 'user':
                return 'App\Models\User';
            case 'clinic':
                return 'App\Models\Clinic';
        }
    }

    private function getWeekSchedule($data) {
        $schedule = [];
        $firstDate = new \DateTime($data['month']);
        $month = (int) $firstDate->format('n');
        $year = (int) $firstDate->format('Y');
        $date = (new \DateTime())->setDate($year, $month, 1);     
        
        while ((int) $date->format('n') === $month) {
            foreach($data['schedule'] as $elem) {
                if ($elem['date'] === (int) $date->format('w')) {
                    $elem['date'] = $date->format('Y-m-dTH:i:s');
                    $schedule[] =  
                    break;
                }
            }
            $date->modify('+1 day');
        }
    }

    private function getShiftSchedule($data) {
        $format = explode('/', $data['format']);
        $date = new \DateTime($data['first_day']);
        $month = (int) $date->format('n');
        while ((int) $date->format('n') === $month) {
            
        }
    }
}