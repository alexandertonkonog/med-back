<? 

namespace App\Services;

use App\Models\File;
use App\Models\Service;
use App\Http\Filters\DoctorFilter;
use Illuminate\Support\Facades\DB;
use App\Http\Filters\ServiceFilter;
use Illuminate\Support\Facades\Storage;

class ServiceService {
    public function select($data) {
        $filter = app()->make(ServiceFilter::class, ['queryParams' => array_filter($data)]);
        return Service::filter($filter)->get();
    }

    public function create($data, $request) {
        DB::beginTransaction();
        $path;
        $entity;
        $file;
        try {
            if (isset($data['img'])) {
                $path = $data['img']->store('avatars', 'public');
                $file = File::create([
                    'url' => $path,
                    'name' => $path
                ]);
            }
            $entityArray = [
                'name' => $data['name'],
            ];
            if (isset($data['external_id'])) {
                $entityArray['external_id'] = $data['external_id'];
            }
            if (isset($data['cost'])) {
                $entityArray['cost'] = $data['cost'];
            }
            if (isset($data['duration'])) {
                $entityArray['duration'] = $data['duration'];
            }
            if (isset($file)) {
                $entityArray['file_id'] = $file->id;
            }
            $entity = Service::create($entityArray);
            DB::commit();
        } catch (\Exception $e) {
            Storage::delete($path);
            DB::rollback();
        }
        return $entity;
    }

    public function upsert($data, $request) {
        
    }
}