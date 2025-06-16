<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthenticatedService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticatedController extends Controller
{
    protected AuthenticatedService $authenticatedService;

    public function __construct(AuthenticatedService $authenticatedService)
    {
        $this->authenticatedService = $authenticatedService;
    }

    public function login(LoginRequest $request) :JsonResponse
    {
        $result = $this->authenticatedService->login($request->validated());
        return response()->json([
            'result' => $result,
            'success' => 'success',
            'message' => 'Login success'
        ]);
    }

}
