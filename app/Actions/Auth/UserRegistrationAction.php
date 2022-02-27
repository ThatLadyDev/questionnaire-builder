<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\RegistrationRequest;
use App\Services\JwtService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRegistrationAction
{
    private JwtService $service;

    public function __construct(JwtService $service)
    {
        $this->service = $service;
    }

    public function execute(RegistrationRequest $request)
    {
        ($request->routeIs('admin.create') === true) ? $request->merge(['is_admin' => 1]) : null;
        $request->merge(['password' => Hash::make($request->password)]);
        User::create($request->except(['password_confirmation']));
        return $this->service->issueToken();
    }
}