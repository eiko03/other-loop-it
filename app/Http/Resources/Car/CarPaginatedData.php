<?php

namespace App\Http\Resources\Car;

use App\Http\Resources\Car\Car as CarResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CarPaginatedData extends ResourceCollection
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
            'items' => CarResource::collection($this->collection),
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage()
            ]
        ];
    }
}
