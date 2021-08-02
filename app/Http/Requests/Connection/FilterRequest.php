<?php

namespace App\Http\Requests\Connection;

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
            'user_id' => 'integer',
            'id' => 'integer',
            'type_id' => 'integer',
            'subtype_id' => 'integer',
            'withType' => 'integer',
        ];
    }
}
