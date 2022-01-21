<?php

namespace App\Http\Controllers\Api\Profile;

use Auth;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\User\UserProfile as UserProfileResource;
use App\Repositories\User\UserRepositoryInterface;
use Log;

class GetDetails extends Controller
{
    private $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $this->userRepo->getUser(Auth::user()->id);
        } catch (\Exception $e) {
            Log::critical('Failed to get user details - ' . $e->getMessage());

            return $this->serverErrorResponse();
        }

        return $this->withSuccessStatus()
            ->withData(['user' => new UserProfileResource($user)])
            ->respond();
    }
}
