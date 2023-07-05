<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        if ($this->method() == "POST") {
            return [
                'email' => 'required|unique:users|email|max:255',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'selected_roles' => 'required|max:255',
            ];
        } else {
            return [
                'email' => 'required|email|max:255',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'selected_roles' => 'required|max:255',
                'id' => 'required|exists:users,id|max:255',
            ];
        }
    }

    public function messages()
    {
        return [
            'email.required' => 'email is required.',
            'selected_roles.required' => 'Role is required.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
