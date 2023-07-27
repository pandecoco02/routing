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
    public function applicants(){ 
        return $this->belongsToMany(Applicant::class, 'id', 'OccupationalPermit_id');
    }
}
