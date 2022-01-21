<?php

namespace Tests\Feature\Api\Auth\Logout;

use Tests\Feature\Api\TestCase;

class LogoutWithValidTokenTest extends TestCase
{
    public function testLogoutWithValidToken()
    {
        /**
         * Arrange
         */
        $token = $this->getValidAccessToken();

        $expected = [
            'status' => 'success'
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
        $response->assertStatus($this->responseCodes['HTTP_OK'])
            ->assertJson($expected);
    }
}
