<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OccupationalPermit extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'permit_id' => $this -> permit_id,
            'OccupationalPermit_id'  => $this-> OccupationalPermit_id,
            'Applicant_id'  => $this-> Applicant_id ,
            'CommunityTaxNumber'  => $this-> CommunityTaxNumber,
            'CommunityTaxFee'  => $this->  CommunityTaxFee,
            'CommunityTaxDatePaid'  => $this-> CommunityTaxDatePaid,
            'MayorsPermitNumber'  => $this-> MayorsPermitNumber,
            'MayorsPermitFee'  => $this-> MayorsPermitFee,
            'MayorsPermitDatePaid'  => $this-> MayorsPermitDatePaid,
            'HealthCardNumber'  => $this-> HealthCardNumber,
            'PoliceClearanceNo'  => $this-> PoliceClearanceNo,
            'PoliceClearanceExpiryDate'  => $this-> PoliceClearanceExpiryDate,
            'DateIssued'  => $this-> DateIssued,
            'DateHired'  => $this-> DateHired,
            'SignatoryID'  => $this-> SignatoryID,
            'EmploymentTypeID'  => $this-> EmploymentTypeID,
            'Status'   => $this-> Status,
        ]; 
    }
}
