<?php

namespace Tests\Feature\Api\Auth\Login;

use Tests\Feature\Api\TestCase;

class IncorrectPasswordValidationTest extends TestCase
{
   public function testIncorrectPasswordValidationOnLogin()
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

      $expectedStatusCode = $this->responseCodes['HTTP_UNAUTHORIZED'];

      $expected = [
         'status'  => 'error',
         'message' => trans('auth.failed'),
      ];

      /**
       * Act
       */
      $response = $this->json('POST', route('api.auth.login'), $credentials);

      /**
       * Assert
       */
      $response->assertStatus($this->responseCodes['HTTP_UNAUTHORIZED'])
         ->assertJson($expected);
   }
}
