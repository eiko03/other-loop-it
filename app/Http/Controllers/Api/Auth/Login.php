<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Http\FormValidations\Auth\LoginFormValidation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Log;

/**
 * Implemented Laravel single action controller for user login
 *
 * Some default methods like sendLoginResponse and sendLockoutResponse of AuthenticateUsers trait are replaced
 * to set the uniformity in the JSON response format
 *
 * Class Login
 * @package App\Http\Controllers\Api\Auth
 */
class Login extends Controller
{
    use AuthenticatesUsers;

    /**
     * same as overriding login method of AuthenticatesUsers trait
     * added login form validation and log for recording any errors
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $loginValidation = new LoginFormValidation($request);

        if ($loginValidation->fails())
            return $this->errorFormValidationResponse($loginValidation);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request))
            return $this->sendLoginResponse($request);

        Log::error('Login failed with email "' . $request->input($this->username()) . '" from IP address ' . $request->ip());

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * method override of AuthenticatesUsers trait
     * to set uniformity in the JSON response format
     * @param Request $request [description]
     * @return bool [type]           [boolean]
     */
    protected function attemptLogin(Request $request): bool
    {
        return $this->guard()->attempt($this->credentials($request));
    }

    /**
     * method override of AuthenticatesUsers trait
     * to set uniformity in the JSON response format
     * @param Request $request [description]
     * @return JsonResponse [type]           [description]
     */
    private function sendFailedLoginResponse($request): JsonResponse
    {
        return $this->withError()
            ->withStatusCode($this->getCode('HTTP_UNAUTHORIZED'))
            ->withMessage(trans('auth.failed'))
            ->respond();
    }

    /**
     * method override of ThrottlesLogins trait
     * @param Request $request [description]
     * @return JsonResponse [type]           [description]
     */
    protected function sendLockoutResponse(Request $request): JsonResponse
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        return $this->withError()
            ->withStatusCode($this->getCode('HTTP_TOO_MANY_REQUESTS'))
            ->withMessage(Lang::get('auth.throttle', ['seconds' => $seconds]))
            ->respond();
    }

    /**
     * method override of AuthenticatesUsers trait
     * @param Request $request [description]
     * @return JsonResponse [type]           [description]
     */
    protected function sendLoginResponse(Request $request): JsonResponse
    {
        $this->clearLoginAttempts($request);

        $token = $this->guard()->user()->createToken('Personal Access Client')->accessToken;

        return $this->withSuccessStatus()
            ->withData(['token' => $token])
            ->respond();
    }
}
