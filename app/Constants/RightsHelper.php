<?php 
namespace App\Constants;

class RightsHelper {
    protected static $rights = [
        [
            'id' => 1,
            'key' => 'ALL_RIGHTS',
            'name' => 'Полные права',
        ]
    ];

    public static function getAll() {
        return static::$rights;
    }

    public static function getByIds(array $ids): array {
        return array_filter(static::$rights, function($value) use ($ids) {
            return in_array($value['id'], $ids);
        });
    }
}
