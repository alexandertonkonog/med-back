<?php

namespace App\Http\Requests\Schedule;

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
            'doctor_id' => ['integer'],
            'clinic_id' => ['integer'],
            'user_id' => ['integer'],
            'moreDateTime' => ['date'],
            'lessDateTime' => ['date'],
            'owner_id' => ['integer'],
            'owner_type' => ['string'],
        ];
    }
}
