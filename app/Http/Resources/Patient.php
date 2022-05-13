<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Patient extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'email'=> $this->email,
            'password'=> $this->password,
            'birth_day'=>$this->birth_day,
            'city'=> $this->city,
            'country'=> $this->country,
            'gender'=> $this->gender,
            'national_id'=> $this->national_id,
            'phone'=> $this->phone,
        ];
    }
}
