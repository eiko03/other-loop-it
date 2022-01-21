<?php

namespace App\Repositories\Car;

use DB;
use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;

class CarRepository implements CarRepositoryInterface
{
    /**
     * @param $searchText
     * @param $pageLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * returns the cars which are in stock
     */
    public function getCarsInStock($searchText, $pageLimit)
    {
        return Car::join('makes', 'makes.id', '=', 'cars.make_id')

            ->join('models', 'models.id', '=', 'cars.model_id')
            ->where(function ($query) {
                $query->where('quantity', '>', 0);
            })
            ->where(function ($query) use ($searchText) {
                $query->where('year', $searchText)
                    ->orWhere('quantity', $searchText)
                    ->orWhere('makes.name', 'like', '%' . $searchText . '%')
                    ->orWhere('models.name', 'like', '%' . $searchText . '%');
            })
            ->select('cars.*', 'makes.name AS make_name', 'models.name AS model_name')
            ->paginate($pageLimit);
    }
}
