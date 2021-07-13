<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\AbstractFilter;

class DoctorFilter extends AbstractFilter {
    public const NAME = 'name';
    public const USER_ID = 'userId';
    public const ID = 'id';

    protected function getCallbacks() : array {
        $result = [
            self::NAME => [$this, 'name'],
            self::USER_ID => [$this, 'userId'],
            self::ID => [$this, 'id'],
        ];
        return $result;
    }

    public function name(Builder $builder, $value) {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function userId(Builder $builder, $value) {
        $builder->where('user_id', $value);
    }

    public function id(Builder $builder, $value) {
        $builder->where('id', $value);
    }

}