<?
namespace App\Utils;

class FilterHelper {
     /**
     * Filter querystring keys by name and format keys as relations keys
     *
     * @param array $data array of GET params
     * 
     * @param string $str filter key
     * 
     * @return fileId
     *
     */
    static public function getRelationsArray($data, $str = 'with') {
        $result = [];
        foreach($data as $key => $value) {
            $hasWith = stripos($key, $str);
            if($hasWith !== false) {
                $leftStr = substr($key, strlen($str));
                $result[] = strtolower($leftStr);
            } 
        }
        return $result;
    }
}