<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\JwtService;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Actions\Auth\UserRegistrationAction;

class RegisterController extends Controller
{
    private UserRegistrationAction $action;

    public function __construct(UserRegistrationAction $action)
    {
        $this->action = $action;
    }

    public function __invoke(RegistrationRequest $request): JsonResponse
    {
        try {
            $token = $this->action->execute($request);
            return new JsonResponse([
                'success' => true,
                'token' => $token,
                'errors' => null
            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
