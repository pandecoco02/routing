<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OccupationalPermitRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == "POST") {
        return [
            'Applicant_id'  => 'required|string|max:255',
            'CommunityTaxNumber'   => 'string|max:255',
            'CommunityTaxFee'  => 'string|max:255',
            'CommunityTaxDatePaid'  => 'string|max:255',
            'MayorsPermitNumber'  => 'string|max:255',
            'MayorsPermitFee'  => 'string|max:255',
            'MayorsPermitDatePaid'  => 'string|max:255',
            'HealthCardNumber'  => 'string|max:255',
            'PoliceClearanceNo'  => 'string|max:255',
            'PoliceClearanceExpiryDate'  => 'string|max:255',
            'DateIssued'  => 'string|max:255',
            'DateHired'  => 'string|max:255',
            'SignatoryID'=>'max:255',
            'EmploymentTypeID'  => 'string|max:255',
            'Status'   => 'string|max:255'
        ];
    }
    else{
        [
            'Applicant_id'  => 'required|string|max:255',
        ];
    }
    }
    public function messages()
    {
        return [
            'Applicant_id.required' => 'ID is required.',
            
        ];
    }
}
