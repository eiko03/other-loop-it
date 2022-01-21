<?php

namespace Tests\Feature\Api\Auth\Login;

use Tests\Feature\Api\TestCase;

class LoginThrottlingTest extends TestCase
{
   private $loginThrottleTimes = 5;

   public function testMultipleLogInAttemptsRestrictionOnLogin()
   {
      /**
       * Arrange
       */
      $user = factory(\App\Models\User::class)
      ->create();

      $credentials = [
         'email'    => $user->email,
         'password' => 'invalid_password',
      ];

      $expected = [
         'status' => 'error',
      ];

      /**
       * Act
       */
      for ($i = 0; $i < $this->loginThrottleTimes; $i++) {
         $this->json('POST', route('api.auth.login'), $credentials);
      }

      $response = $this->json('POST', route('api.auth.login'), $credentials);

      /**
       * Assert
       */
      $response->assertStatus($this->responseCodes['HTTP_TOO_MANY_REQUESTS'])
         ->assertJson($expected);
   }
}
