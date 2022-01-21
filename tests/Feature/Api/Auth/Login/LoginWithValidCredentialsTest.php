<?php

namespace Tests\Feature\Api\Auth\Login;

use Tests\Feature\Api\TestCase;

class LoginWithValidCredentialsTest extends TestCase
{
   public function testLoginWithCorrectCredentials()
   {
      /**
       * Arrange
       */
      $user = factory(\App\Models\User::class)
      ->create(['password' => bcrypt('secret')]);

      $credentials = [
         'email'    => $user->email,
         'password' => 'secret',
      ];

      $expected = [
         'status' => 'success',
      ];

      /**
       * Act
       */
      $response = $this->json('POST', route('api.auth.login'), $credentials);

      /**
       * Assert
       */
      $response->assertStatus($this->responseCodes['HTTP_OK'])
         ->assertJson($expected);
   }
}
