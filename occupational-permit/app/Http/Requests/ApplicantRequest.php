<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApplicantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
                'Photo' => 'image|mimes:jpg,png,jpeg',
                'permit' => 'string|max:255'
            ];
        } 
        else {
            return [
                'LastName' => 'required|string|max:255',
                'FirstName' => 'required|string|max:255',
                'Age' => 'required|integer',
                'CivilStatus' => 'required|string|max:255',
                'permit' => 'string|max:255'
                //photo
            ];
        }
    }
    public function messages()
    {
        return [
            'LastName' => 'email is required.',
            'FirstName' => 'First Name is required.',
            'Age' => 'Age is required.',
            'CivilStatus' => 'Civil Status is required.',
        ];
    }
}
