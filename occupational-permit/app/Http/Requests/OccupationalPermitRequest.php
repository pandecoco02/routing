<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OccupationalPermitRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'CommunityTaxNumber'   => 'required|string|max:255',
            'CommunityTaxFee'  => 'required|string|max:255',
            'CommunityTaxDatePaid'  => 'required|max:255',
            'MayorsPermitNumber'  => 'required|string|max:255',
            'MayorsPermitFee'  => 'required|string|max:255',
            'MayorsPermitDatePaid'  => 'required|string|max:255',
            'HealthCardNumber'  => 'required|string|max:255',
            'PoliceClearanceNo'  => 'required|string|max:255',
            'PoliceClearanceExpiryDate'  => 'required|max:255',
            'DateIssued'  => 'required|string|max:255',
            'PermitNo'  => 'required|string|max:255',
            'DateHired'  => 'required|max:255',
            'ApplicantID'  => 'required|string|max:255',
            'SignatoryID'  => 'required|string|max:255',
            'EmploymentTypeID'  => 'required|string|max:255',
            'Status'   => 'required|string|max:255'
        ];
    }
}
