<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListIndex extends JsonResource
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
            "id"=> $this->id,
            "name_methods" => $this->name_methods,
            "name_months" => $this->name_months,
            "activity"=> $this->activity,
            "date_start"=> $this->date_start,
            "date_end"=> $this->date_end
        ];
    }
}