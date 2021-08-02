<?php

namespace App\Http\Requests\Specialization;

use App\Http\Requests\ApiFormRequest;

class CreateRequest extends ApiFormRequest
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
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'external_id' => ['string'],
            'description' => ['string'],
            'code' => ['required', 'string'],
            'doctors' => ['array'],
            'services' => ['array'],
            'doctors.*' => ['integer'],
            'services.*' => ['integer'],
        ];
    }
}
