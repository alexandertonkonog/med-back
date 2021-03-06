<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => ['required', 'unique:users', 'max:255', 'min:7'],
            'password' => ['required', 'confirmed', 'max:20', 'min:7'],
            'name' => ['required', 'max:100', 'min:7'],
            'type' => ['required', 'integer'],
        ];
    }
}
