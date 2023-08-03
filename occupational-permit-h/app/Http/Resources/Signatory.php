<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Signatory extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'LastName' => $this->LastName,
            'FirstName' => $this->FirstName,
            'MiddleName' => $this->MiddleName,
            'ExtensionName' => $this->ExtensionName,
            'Position' => $this->Position,
            'DivisionName' => $this->DivisionName,
            'OfficeName' => $this->OfficeName,
            'City' => $this->City,
        ];
    }
}
