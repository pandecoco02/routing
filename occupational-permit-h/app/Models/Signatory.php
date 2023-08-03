<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signatory extends Model
{
    use HasFactory;
    protected $fillable = [
        'LastName',
        'FirstName',
        'MiddleName',
        'ExtensionName',
        'Position',
        'DivisionName',
        'OfficeName',
        'City'
    ];
    public function permits(){ 
        return $this->belongsToMany(OccupationalPermit::class, 'permit_id','Applicant_id');
    }
}
