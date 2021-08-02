<?php

namespace App\Http\Requests\Service;

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
            'cost' => 'string',
            'id' => 'integer',
            'user_id' => 'integer',
            'withDoctors' => 'integer',
            'withSpecializations' => 'integer',
            'withImg' => 'integer',
        ];
    }
}
