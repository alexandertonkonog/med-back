<?php

namespace App\Http\Requests\Schedule;

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
            'format' => ['string', 'max:20'],
            'type' => ['required', 'integer'],
            'month' => ['required', 'date'],
            'first_day' => ['date'],
            'schedule' => ['required', 'string'],
            'scheduleable_id' => ['required', 'integer'],
            'scheduleable_type' => ['required', 'string'],
        ];
    }
}
