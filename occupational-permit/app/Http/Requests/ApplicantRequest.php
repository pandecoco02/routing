<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApplicantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules() 
    {
        if ($this->method() == "POST") {
            return [
                'LastName' => 'required|string|max:255',
                'FirstName' => 'required|string|max:255',
                'MiddleName' => 'string|max:255',
                'ExtensionName' => 'max:255',
                'Age' => 'required|integer',
                'CivilStatus' => 'required|string|max:255',
                'Photo' => 'image|mimes:jpg,png,jpeg'
            ];
        } 
        else {
            return [
                'LastName' => 'required|string|max:255',
                'FirstName' => 'required|string|max:255',
                'MiddleName' => 'string|max:255',
                'ExtensionName' => 'max:255',
                'Age' => 'required|integer',
                'CivilStatus' => 'required|string|max:255'
                //photo
            ];
        }
    }
    public function messages()
    {
        return [
            'LastName' => 'email is required.',
            'FirstName' => 'First Name is required.',
        ];
    }
}
