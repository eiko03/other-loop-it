<?php

namespace Tests\Feature\Api\Car;

use Tests\Feature\Api\TestCase;

class GetCarsInStockTest extends TestCase
{
    public function testGetCarsInStock()
    {
        /**
         * Arrange
         */
        $token = $this->getValidAccessToken();

        $carsInStock = factory(\App\Models\Car::class, 10)
            ->state('in-stock')
            ->create();

        $carsOutOfStock = factory(\App\Models\Car::class, 5)
            ->state('out-of-stock')
            ->create();

        $expected = [
            'status' => 'success'
        ];

        /**
         * Act
         */
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])
            ->json('POST', route('api.car.in-stock'));

        /**
         * Assert
         */
        $response->assertStatus($this->responseCodes['HTTP_OK'])
            ->assertJson($expected)
            ->assertJsonCount($carsInStock->count(), 'data.cars.items');
    }
}
