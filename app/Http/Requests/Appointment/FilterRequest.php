<?php

namespace App\Http\Requests\Appointment;

use App\Http\Requests\ApiFormRequest;

class FilterRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['integer'],
            'moreDateTime' => ['date'],
            'lessDateTime' => ['date'],
            'confirmed' => ['boolean'],
            'doctor_id' => ['integer'],
            'service_id' => ['integer'],
            'external_id' => ['string', 'max:50'],
            'specialization_id' => ['integer'],
            'user_id' => ['integer'],
            'clinic_id' => ['integer'],
            'withDoctor' => ['boolean'],
            'withService' => ['boolean'],
            'withSpecialization' => ['boolean'],
            'withClinic' => ['boolean'],
            'withUser' => ['boolean'],
        ];
    }
}
