<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OccupationalPermit extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'OccupationalPermit_id'  => $this-> OccupationalPermit_id,
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
            'PermitNo'  => $this-> PermitNo,
            'DateHired'  => $this-> DateHired,
            'ApplicantID'  => $this-> ApplicantID,
            'SignatoryID'  => $this-> SignatoryID,
            'EmploymentTypeID'  => $this-> EmploymentTypeID,
            'Status'   => $this-> Status,
        ]; 
    }
}
