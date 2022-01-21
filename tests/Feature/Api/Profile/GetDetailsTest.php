<?php

namespace Tests\Feature\Api\Profile;

use App\Http\Resources\User\UserProfile as UserProfileResource;
use Tests\Feature\Api\TestCase;

class GetDetailsTest extends TestCase
{
   public function testGetProfileDetails()
   {
      /**
       * Arrange
       */
      $user = factory(\App\Models\User::class)
         ->create();

      $token = $user->createToken('Personal Access Client')->accessToken;

      $expected = [
         'status' => 'success',
         'data'   => [
            'user' => (new UserProfileResource($user))->resolve(),
         ],
      ];

      /**
       * Act
       */
      $response = $this->withHeaders([
         'Authorization' => 'Bearer ' . $token,
      ])
      ->json('GET', route('api.profile.get-details'));

      /**
       * Assert
       */
      $response->assertStatus($this->responseCodes['HTTP_OK'])
         ->assertJson($expected);
   }
}
