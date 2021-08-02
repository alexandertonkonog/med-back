<?php

namespace App\Http\Requests\Service;

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
            'name' => ['string', 'min:5', 'max:255'],
            'external_id' => ['string'],
            'duration' => ['integer'],
            'cost' => ['integer'],
            'code' => ['string'],
            'img' => ['dimensions:min_width=100,min_height=100', 'max:1000'],
            'doctors' => ['array'],
            'specializations' => ['array'],
            'doctors.*' => ['integer'],
            'specializations.*' => ['integer'],
        ];
    }
}
