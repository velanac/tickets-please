<?php

namespace App\Http\Controllers;

use App\Traits\ApiRespones;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    use ApiRespones;

    public function login(LoginRequest $request)
    {
        return $this->ok($request->get('email'));
    }

    public function register()
    {
        return $this->ok('register');
    }
}
