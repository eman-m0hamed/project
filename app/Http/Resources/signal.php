<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class signal extends JsonResource
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
            'type'=> $this->type,
            'classification'=> $this->classification,
            'prop_of_seiz'=> $this->prop_of_seiz,
            'prop_of_non_seiz'=>$this->prop_of_non_seiz,

        ];
    }
}
