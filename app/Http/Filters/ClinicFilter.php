<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\AbstractFilter;

class ClinicFilter extends AbstractFilter {
    public const NAME = 'name';
    public const ID = 'id';
    public const USER_ID = 'user_id';

    protected function getCallbacks() : array {
        $result = [
            self::NAME => [$this, 'name'],
            self::ID => [$this, 'id'],
            self::USER_ID => [$this, 'user_id'],
        ];
        return $result;
    }

    public function name(Builder $builder, $value) {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function id(Builder $builder, $value) {
        $builder->where('id', $value);
    }

    public function user_id(Builder $builder, $value) {
        $builder->where('user_id', $value);
    }

}