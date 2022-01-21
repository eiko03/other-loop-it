<?php

namespace App\Repositories\Car;

interface CarRepositoryInterface
{
    public function getCarsInStock($searchText, $pageLimit);
}
