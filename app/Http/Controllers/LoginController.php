<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\LoginAuthRequest;
use Illuminate\Validation\UnauthorizedException;

class LoginController extends Controller
{
    public function index(): View
    {
        $successMessage = session('success.message');

        return view('login.index')
            ->with('successMessage', $successMessage);
    }

    public function authenticate(LoginAuthRequest $request): Redirector|RedirectResponse
    {
        return (Auth::attempt($request->only(['email', 'password'])))
            ? to_route('series.index')
            : to_route('login')->withErrors('Email e/ou senha incorreto');


        return to_route('series.index');
    }

    public function logout(): Redirector|RedirectResponse
    {
        Auth::logout();
        return to_route('login');
    }
}
