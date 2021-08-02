<?php

namespace App\Http\Requests\Doctor;

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
            'img' => ['dimensions:min_width=100,min_height=100', 'max:1000'],
            'files' => ['array', 'max:5'],
            'services' => ['array'],
            'specializations' => ['array'],
            'files.*' => ['file', 'max:3000'],
            'services.*' => ['integer', 'numeric'],
            'specializations.*' => ['integer'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'services.*' => ['integer', 'numeric'],
            'specializations.*' => ['integer'],
        ]);
    }
}
