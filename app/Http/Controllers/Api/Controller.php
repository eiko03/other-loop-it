<?php

namespace App\Http\Controllers\Api;

use App\Traits\ManageAPIResponse;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use ManageAPIResponse;

    /**
     * common method for setting success state in the response
     * sets header status code to 200, and adds 'success' in status key of payload
     * response payload format:
     * {
     *    'status': 'success'
     * }
     * @return Controller|\App\Http\Middleware\Api\Authenticate|ManageAPIResponse
     */
    public function withSuccessStatus()
    {
        return $this->withSuccess()
            ->withStatusCode($this->getCode('HTTP_OK'));
    }

    /**
     * common method for sending server error response
     * @return JsonResponse
     */
    public function serverErrorResponse(): JsonResponse
    {
        return $this->withError()
            ->withStatusCode($this->getCode('HTTP_INTERNAL_SERVER_ERROR'))
            ->withMessage("Error while processing the request!!")
            ->respond();
    }

    /**
     * common method for sending validation error such as user not authorized, can't delete item which is shown as notification not as form validation
     * @param $statusCodeKey
     * @param $validation
     * @return JsonResponse
     */
    public function errorValidationResponse($statusCodeKey, $validation): JsonResponse
    {
        $response = $this->withError()
            ->withStatusCode($this->getCode($statusCodeKey))
            ->withMessage($validation->getErrorMessage());

        if ($validation->hasErrorData())
            return $response->withData($validation->getErrorData())
                ->respond();

        return $response->respond();
    }

    /**
     * return formatted validation errors response
     * common method for sending form validation errors
     * @param  [Validator] $validation
     * @return JsonResponse [Response]
     */
    protected function errorFormValidationResponse($validation): JsonResponse
    {
        return $this->withFail()
            ->withStatusCode($this->getCode('HTTP_UNPROCESSABLE_ENTITY'))
            ->withData($validation->getValidator()->errors()->toArray())
            ->respond();
    }
}
