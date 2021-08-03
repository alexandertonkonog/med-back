<?php

namespace App\Http\Requests\Schedule;

use App\Http\Requests\ApiFormRequest;

class UpdateRequest extends ApiFormRequest
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
            'id' => ['required', 'integer'],
            'dateTime' => ['date'],
            'confirmed' => ['boolean'],
            'comment' => ['string', 'max:255'],
            // 'doctor_id' => ['integer'],
            // 'service_id' => ['integer'],
            // 'external_id' => ['string', 'max:50'],
            // 'specialization_id' => ['integer'],
            // 'clinic_id' => ['integer'],
        ];
    }
}
