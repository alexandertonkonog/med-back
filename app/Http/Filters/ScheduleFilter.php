<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\AbstractFilter;

class ScheduleFilter extends AbstractFilter {
    public const MOREDATETIME = 'moreDateTime';
    public const LESSDATETIME = 'lessDateTime';
    public const CURRENT = 'current';
    public const ID = 'id';
    public const USER_ID = 'user_id';
    public const DOCTOR_ID = 'doctor_id';
    public const OWNER_ID = 'owner_id';
    public const OWNER_TYPE = 'owner_type';
    public const CLINIC_ID = 'clinic_id';

    protected function getCallbacks() : array {
        $result = [
            self::MOREDATETIME => [$this, 'moreDateTime'],
            self::LESSDATETIME => [$this, 'lessDateTime'],
            self::CURRENT => [$this, 'current'],
            self::ID => [$this, 'id'],
            self::USER_ID => [$this, 'user_id'],
            self::DOCTOR_ID => [$this, 'doctor_id'],
            self::CLINIC_ID => [$this, 'clinic_id'],
            self::OWNER_ID => [$this, 'owner_id'],
            self::OWNER_TYPE => [$this, 'owner_type'],
        ];
        return $result;
    }

    public function moreDateTime(Builder $builder, $value) {
        $builder->where('started_at', '>' , $value);
    }

    public function lessDateTime(Builder $builder, $value) {
        $builder->where('deleted_at', '<' , $value);
    }

    public function user_id(Builder $builder, $value) {
        $builder->where('user_id', $value);
    }

    public function current(Builder $builder, $value) {
        $builder->where('deleted_at', '>', (new \DateTime())->format(('Y-m-d')));
    }

    public function doctor_id(Builder $builder, $value) {
        $builder->where('doctor_id', $value);
    }

    public function owner_id(Builder $builder, $value) {
        $builder->where('scheduleable_id', $value);
    }

    public function owner_type(Builder $builder, $value) {
        $type = $this->getType($value);
        $builder->where('scheduleable_type', $type);
    }

    public function clinic_id(Builder $builder, $value) {
        $builder->where('doctor_id', $value);
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

}