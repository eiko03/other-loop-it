<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\Resources\Json\JsonResource;

class Car extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'year' => $this->year,
            'quantity' => $this->quantity,
            'make_name' => $this->make_name,
            'model_name' => $this->model_name
        ];
    }
}
