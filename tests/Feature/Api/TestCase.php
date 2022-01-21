<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
	use WithFaker;
	use DatabaseTransactions;

   protected $validationMessages;
   protected $responseCodes;

   public function __construct()
   {
      parent::__construct();

      $this->setupDefaultValidationMessages();
      $this->setupResponseCodes();
   }

   protected function getValidationErrorMessage($key, $value = null)
   {
      switch ($key) {
         case 'max':
         case 'min':
            return str_replace(':' . $key, $value, $this->validationMessages[$key]);
            break;

         default:
            return $this->validationMessages[$key];
            break;
      }
   }

   private function setupDefaultValidationMessages()
   {
      $this->validationMessages = [
         'required'    => '* required',
         'numeric'     => '* numeric',
         'email'       => '* invalid email',
         'date'        => '* invalid date',
         'max'         => '* max length is :max',
         'min'         => '* min length is :min',
         'unique'      => '* already exist',
         'exists'      => "* doesn't exist",
         'date_format' => '* invalid date format',
         'boolean'     => '* invalid input',
         'file'        => '* invalid file',
      ];
   }

   private function setupResponseCodes()
   {
      $this->responseCodes = [
         'HTTP_OK'                    => 200,
         'HTTP_TOO_MANY_REQUESTS'     => 429,
         'HTTP_UNAUTHORIZED'          => 401,
         'HTTP_INTERNAL_SERVER_ERROR' => 500,
         'HTTP_CONFLICT'              => 409,
         'HTTP_UNPROCESSABLE_ENTITY'  => 422,
      ];
   }

   protected function getValidAccessToken()
   {
		return factory(\App\Models\User::class)

		->create()
		->createToken('Personal Access Client')
		->accessToken;
   }
}
