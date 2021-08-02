<?
namespace App\Utils;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileHelper {
    function __construct($data, $disk = 'public') {
        $this->data = $data;
        $this->disk = $disk;
        $this->path = null;
        $this->filesPaths = [];
    }   
    /**
     * Create files and create relations to entity
     *
     * @param array $data contains entity id and name for creating file
     * 
     * @return void
     *
     */
    public function saveRelationFiles() {
        $files = [];
        foreach($this->data['files'] as $item) {
            $path = $item->store('', $this->disk);
            $arr = [
                'path' => $path,
                'disk' => $this->disk,
            ];
            $files[] = $arr;
            $this->filesPaths[] = $path;
        }
        return $files;
    }

    /**
     * Remove saved files by error
     *
     * 
     * @return void
     *
     */
    public function errorRemoveFiles() {
        if (count($this->filesPaths)) {
            Storage::disk($this->disk)->delete($this->filesPaths);
        } 
        if ($this->path) {
            Storage::disk($this->disk)->delete($this->path);
        }
    }

    /**
     * Remove files from entity
     *
     * @param Model $entity 
     * 
     * @return void
     *
     */
    public function updateRelationFiles($entity) {
        if (isset($this->data['removeFiles'])) {
            foreach($entity->files as $item) {
                if (in_array($item->id, $this->data['removeFiles'])) {
                    $item->delete();
                }
            }  
        }
        return $this->saveRelationFiles();
    }
    /**
     * Create file and return file id
     *
     * @return fileId
     *
     */
    public function createFile() {
        $this->path = $this->data['img']->store('avatars', $this->disk); 
        $response = [
            'disk' => $this->disk,
            'path' => $this->path
        ];
        return $response;
    }

    /**
     * Create new file and remove old file and update entity
     *
     * @param Model $entity 
     * 
     * @return void
     *
     */
    public function updateFile($entity) {
        if ($entity->img) {
            $entity->img->delete();
        }
        $path = $this->data['img']->store('avatars', $this->disk);
        return [
            'path' => $path,
            'disk' => $this->disk,
        ];
    }
}