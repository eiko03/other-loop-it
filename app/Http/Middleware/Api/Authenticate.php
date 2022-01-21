<?php

namespace App\Http\Middleware\Api;

use App\Traits\ManageAPIResponse;
use Auth;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Log;

/**
 * Class Authenticate
 * @package App\Http\Middleware\Api
 * Extending the default Authenticate middleware for sending uniform unauthorized json response instead of default unauthorized code and text
 */
class Authenticate extends Middleware
{
    use ManageAPIResponse; // ManageAPIResponse trait is used so that the response has uniformity

    public function handle($request, Closure $next, ...$guards): \Illuminate\Http\JsonResponse
    {
        if (!$this->authenticate($request, $guards)) {
            return $this->getUnAuthorizedResponse();
        }

        return $next($request);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * returns unauthorized response
     * payload of response is shown below
     * {
     *    status: 'error',
     *    message: trans('auth.unauthorized') // default unauthorized message from resources/lang
     * }
     */
    private function getUnAuthorizedResponse(): \Illuminate\Http\JsonResponse
    {
        return $this->withError()
            ->withStatusCode($this->getCode('HTTP_UNAUTHORIZED'))
            ->withMessage(trans('auth.unauthorized'))
            ->respond();
    }

    /**
     * method override
     * @param  [type] $request [description]
     * @param array $guards [description]
     * @return bool [type]          [description]
     */
    protected function authenticate($request, array $guards): bool
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $this->auth->shouldUse($guard);
                return true;
            }
        }

        return false;
    }
}
