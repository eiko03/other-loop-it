<?php

namespace Tests\Feature\Api\Auth\Logout;

use Tests\Feature\Api\TestCase;

class LogoutWithInvalidTokenTest extends TestCase
{
    public function testLogoutWithInvalidToken()
    {
        /**
         * Arrange
         */
        $token = "invalid_token";

        $expected = [
            'status' => 'error',
            'message' => trans('auth.unauthorized')
        ];

        /**
         * Act
         */
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])
            ->json('GET', route('api.auth.logout'));

        /**
         * Assert
         */
        $response->assertStatus($this->responseCodes['HTTP_UNAUTHORIZED'])
            ->assertJson($expected);
    }
}
