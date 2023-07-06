<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccupationalPermit extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'OccupationalPermit_id',
        'CommunityTaxNumber',
        'CommunityTaxFee',
        'CommunityTaxDatePaid',
        'MayorsPermitNumber',
        'MayorsPermitFee',
        'MayorsPermitDatePaid',
        'HealthCardNumber',
        'PoliceClearanceNo',
        'PoliceClearanceExpiryDate',
        'DateIssued',
        'PermitNo',
        'DateHired',
        'ID',
        'ApplicantID',
        'SignatoryID',
        'EmploymentTypeID',
        'Status',
    ];
    public function getApplicant(){ 
        return $this->hasOne(Applicant::class, 'id');
    }
}
