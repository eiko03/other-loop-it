<?php

namespace Tests\Feature\Api\Auth\Login;

use Tests\Feature\Api\TestCase;

class EmptyPasswordValidationTest extends TestCase
{
    public function testEmptyPasswordValidationOnLogin()
    {
        /**
         * Arrange
         */
        $credentials = [
            'email' => 'test@gmail.com',
            'password' => ''
        ];

        $expectedStatusCode = $this->responseCodes['HTTP_UNPROCESSABLE_ENTITY'];

        $expectedPayload = [
            'status' => 'fail',
            'data' => [
                'password' => [
                    $this->getValidationErrorMessage('required')
                ]
            ]
        ];

        /**
         * Act
         */
        $response = $this->json('POST', route('api.auth.login'), $credentials);

        /**
         * Assert
         */
        $response->assertStatus($expectedStatusCode)
            ->assertJson($expectedPayload);
    }
}
