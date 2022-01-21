<?php

namespace Tests\Feature\Api\Auth\Login;

use Tests\Feature\Api\TestCase;

class EmptyEmailValidationTest extends TestCase
{
    public function testEmptyEmailValidationOnLogin()
    {
        /**
         * Arrange
         */
        $credentials = [
            'email' => '',
            'password' => 'password'
        ];

        $expectedStatusCode = $this->responseCodes['HTTP_UNPROCESSABLE_ENTITY'];
        $expectedPayload = [
            'status' => 'fail',
            'data' => [
                'email' => [
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
