<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): Redirector|RedirectResponse
    {
        $data = $request->except(['_token']);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        Auth::login($user);

        return to_route('series.index')
            ->with('success.message', "Usuário registrado com sucesso com sucesso");;
    }
}
