<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class symptom_user extends JsonResource
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
            'id'=> $this->id,
            'user_id'=> $this->user_id,
            'symptom_id'=> $this->symptom_id,
        ];
    }
}
