<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RoleRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        if ($this->method() == "POST") {
            return [
                'name' => 'required|string|max:255'
            ];
        } else {
            return [
                'name' => 'required|string|max:255',
                'id' => 'required|exists:roles,id|max:255'
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Role name is required.',
            'id.required'  => 'Role is not exist'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
