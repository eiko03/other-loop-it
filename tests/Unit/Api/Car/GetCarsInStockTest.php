<?php

namespace Tests\Unit\Api\Car;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GetCarsInStockTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetCarsInStockPageLimit()
    {
        /**
         * Arrange
         */
        factory(\App\Models\Car::class, 10)
            ->state('in-stock')
            ->create();

        $searchText = '';
        $firstPageLimit = 5;
        $secondPageLimit = 10;

        /**
         * Act
         */
        $carRepo = $this->app->make(\App\Repositories\Car\CarRepositoryInterface::class);

        $firstCarsResult = $carRepo->getCarsInStock($searchText, $firstPageLimit);
        $secondCarsResult = $carRepo->getCarsInStock($searchText, $secondPageLimit);

        /**
         * Assert
         */
        $this->assertCount($firstPageLimit, $firstCarsResult);
        $this->assertCount($secondPageLimit, $secondCarsResult);
    }

    public function testSearchFilterWhileGettingCarsInStock()
    {
        /**
         * Arrange
         */
        $year = 2010;
        $anotherYear = 2020;
        $expectedNumberOfCars = 10;

        factory(\App\Models\Car::class, $expectedNumberOfCars)
            ->state('in-stock')
            ->create(['year' => $year]);

        factory(\App\Models\Car::class, 5)
            ->state('in-stock')
            ->create(['year' => $anotherYear]);

        $searchText = $year;
        $pageLimit = 20;

        /**
         * Act
         */
        $carRepo = $this->app->make(\App\Repositories\Car\CarRepositoryInterface::class);

        $result = $carRepo->getCarsInStock($searchText, $pageLimit);

        /**
         * Assert
         */
        $this->assertCount($expectedNumberOfCars, $result);
    }

    /**
     * other unit tests can be added such as check if each search filters works or not
     */
}
