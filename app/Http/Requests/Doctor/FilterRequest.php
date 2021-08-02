<?php

namespace App\Http\Requests\Doctor;

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
            'name' => 'string',
            'user_id' => 'integer',
            'id' => 'integer',
            'withServices' => 'integer',
            'withFiles' => 'integer',
            'withSpecializations' => 'integer',
            'withImg' => 'integer',
        ];
    }
}
