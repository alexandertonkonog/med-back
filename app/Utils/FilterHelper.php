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
     * @param array $arr array replaced values
     * 
     * @return fileId
     *
     */
    static public function getRelationsArray($data, $str = 'with', $arr = []) {
        $result = [];
        foreach($data as $key => $value) {
            $hasWith = stripos($key, $str);
            if($hasWith !== false) {
                $leftStr = substr($key, strlen($str));
                $res = strtolower($leftStr);
                if ($arr && count($arr) && isset($arr[$res])) {
                    $result[] = $arr[$res];
                } else {
                    $result[] = $res;
                }   
            } 
        }
        return $result;
    }
}