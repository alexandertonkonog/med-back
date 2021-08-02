<?php

namespace App\Http\Requests\Connection;

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
            'login' => ['string', 'max:255'],
            'url' => ['string', 'max:255'],
            'duration' => ['integer'],
            'password' => ['string', 'max:255'],
            'type_id' => ['integer'],
            'subtype_id' => ['integer'],
            'props' => ['string']
        ];
    }
}
