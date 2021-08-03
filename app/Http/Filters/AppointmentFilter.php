<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\AbstractFilter;

class AppointmentFilter extends AbstractFilter {
    public const MOREDATETIME = 'moreDateTime';
    public const LESSDATETIME = 'lessDateTime';
    public const ID = 'id';
    public const USER_ID = 'user_id';
    public const DOCTOR_ID = 'doctor_id';
    public const SERVICE_ID = 'service_id';
    public const EXTERNAL_ID = 'external_id';
    public const SPECIALIZATION_ID = 'specialization_id';
    public const CLINIC_ID = 'clinic_id';
    public const CONFIRMED = 'confirmed';

    protected function getCallbacks() : array {
        $result = [
            self::MOREDATETIME => [$this, 'moreDateTime'],
            self::LESSDATETIME => [$this, 'lessDateTime'],
            self::ID => [$this, 'id'],
            self::USER_ID => [$this, 'user_id'],
            self::DOCTOR_ID => [$this, 'doctor_id'],
            self::SERVICE_ID => [$this, 'service_id'],
            self::EXTERNAL_ID => [$this, 'external_id'],
            self::SPECIALIZATION_ID => [$this, 'specialization_id'],
            self::CLINIC_ID => [$this, 'clinic_id'],
            self::CONFIRMED => [$this, 'confirmed'],
        ];
        return $result;
    }

    public function moreDateTime(Builder $builder, $value) {
        $builder->where('dateTime', '>' , $value);
    }

    public function lessDateTime(Builder $builder, $value) {
        $builder->where('dateTime', '<' , $value);
    }

    public function id(Builder $builder, $value) {
        $builder->where('id', $value);
    }

    public function user_id(Builder $builder, $value) {
        $builder->where('user_id', $value);
    }

    public function doctor_id(Builder $builder, $value) {
        $builder->where('doctor_id', $value);
    }

    public function service_id(Builder $builder, $value) {
        $builder->where('doctor_id', $value);
    }

    public function external_id(Builder $builder, $value) {
        $builder->where('doctor_id', $value);
    }

    public function specialization_id(Builder $builder, $value) {
        $builder->where('doctor_id', $value);
    }

    public function clinic_id(Builder $builder, $value) {
        $builder->where('doctor_id', $value);
    }

    public function confirmed(Builder $builder, $value) {
        $builder->where('confirmed', $value);
    }

}