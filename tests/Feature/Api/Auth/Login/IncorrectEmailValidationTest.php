<?php

namespace Tests\Feature\Api\Auth\Login;

use Tests\Feature\Api\TestCase;

class IncorrectEmailValidationTest extends TestCase
{
   public function testIncorrectEmailValidationOnLogin()
   {
      /**
       * Arrange
       */
      $credentials = [
         'email'    => 'incorrect@email.com',
         'password' => 'password',
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
      $response->assertStatus($expectedStatusCode)
         ->assertJson($expected);
   }
}
