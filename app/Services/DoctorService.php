<? 

namespace App\Services;

use App\Models\File;
use App\Models\Doctor;
use App\Http\Filters\DoctorFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DoctorService {
    public function select($data) {
        $filter = app()->make(DoctorFilter::class, ['queryParams' => array_filter($data)]);
        return Doctor::filter($filter)->get();
    }

    public function create($data, $request) {
        DB::beginTransaction();
        $path;
        $doctor;
        $file;
        try {
            if (isset($data['img'])) {
                $path = $data['img']->store('avatars', 'public');
                $file = File::create([
                    'url' => $path,
                    'name' => $path
                ]);
            }
            $doctorArray = [
                'name' => $data['name'],
                'user_id' => $data['user_id'],
            ];
            if (isset($data['external_id'])) {
                $doctorArray['external_id'] = $data['external_id'];
            }
            if (isset($file)) {
                $doctorArray['file_id'] = $file->id;
            }
            $doctor = Doctor::create($doctorArray);
            DB::commit();
        } catch (\Exception $e) {
            Storage::delete($path);
            DB::rollback();
        }
        
        return $doctor;
    }

    public function upsert($data, $request) {
        
    }
}