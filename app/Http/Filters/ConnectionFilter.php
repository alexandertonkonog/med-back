<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\AbstractFilter;

class ConnectionFilter extends AbstractFilter {
    public const TYPE_ID = 'type_id';
    public const SUBTYPE_ID = 'subtype_id';
    public const ID = 'id';
    public const USER_ID = 'user_id';

    protected function getCallbacks() : array {
        $result = [
            self::TYPE_ID => [$this, 'type_id'],
            self::SUBTYPE_ID => [$this, 'subtype_id'],
            self::ID => [$this, 'id'],
            self::USER_ID => [$this, 'user_id'],
        ];
        return $result;
    }

    public function type_id(Builder $builder, $value) {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function subtype_id(Builder $builder, $value) {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function id(Builder $builder, $value) {
        $builder->where('id', $value);
    }

    public function user_id(Builder $builder, $value) {
        $builder->where('user_id', $value);
    }

}