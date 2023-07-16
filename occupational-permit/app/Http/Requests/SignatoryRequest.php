<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignatoryRequest extends FormRequest
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
                'ExtensionName' => 'required|string|max:255',
                'Position' => 'required|string|max:255',
                'DivisionName' => 'required|string|max:255',
                'OfficeName' => 'required|string|max:255',
                'City' => 'required|string|max:255',
            ];
        } 
        else {
            return [
                'LastName' => 'required|string|max:255',
                'FirstName' => 'required|string|max:255',
                'MiddleName' => 'string|max:255',
                'ExtensionName' => 'required|string|max:255',
                'Position' => 'required|string|max:255',
                'DivisionName' => 'required|string|max:255',
                'OfficeName' => 'required|string|max:255',
                'City' => 'required|string|max:255',
            ];
        }
    }
}
