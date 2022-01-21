<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Log;

/**
 * Class Logout
 * @package App\Http\Controllers\Api\Auth
 */
class Logout extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $token = $request->user()->token();
            $token->revoke();
        } catch (\Exception $e) {
            Log::critical('Failed to logout - ' . $e->getMessage());

            return $this->serverErrorResponse();
        }

        return $this->withSuccessStatus()->respond();
    }
}
