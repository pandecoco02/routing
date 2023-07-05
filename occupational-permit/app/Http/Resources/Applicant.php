<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Applicant extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'LastName' => $this->LastName,
            
            'FirstName' => $this->FirstName,
            'MiddleName' => $this->MiddleName,
            'ExtensionName' => $this->ExtensionName,
            'Age' => $this->Age,
            'CivilStatus' => $this->CivilStatus,
            'Photo' => $this->Photo,
           
            
        ];
    }
}
