<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public static $wrap = 'car';
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
            'model_name' => $this->model_name,
            'year' => $this->year,
            'manufacturer' => $this->manufacturer,
            'user' => $this->user,
        ];
    }
}
