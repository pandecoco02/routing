<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'is_new' => $this->is_new,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'extension_name' => $this->extension_name,
            'address' => $this->address,
            'contact_no' => $this->contact_no,
            'position' => $this->position,
            'work_place' => $this->work_place,
            'roles' => $this->roles ? Role::collection($this->roles) : [],
        ];
    }
}
