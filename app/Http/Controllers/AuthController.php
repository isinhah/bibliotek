<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLogin(): Response
    {
        return Inertia::render('Auth/Login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            $this->authService->attemptLogin($request->toDTO());
            return redirect('/');
        } catch (Exception $e) {
            return back()
                ->withErrors([
                    'email'    => $e->getMessage(),
                    'password' => 'Verifique a senha inserida.'
                ])
                ->withInput();
        }
    }

    public function showRegister(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        try {
            $this->authService->registerUser($request->toDTO());

            return redirect()->route('home')
                ->with('success', 'Cadastro realizado com sucesso!');
        } catch (Exception $e) {
            return back()
                ->withErrors([
                    'email' => $e->getMessage()
                ])
                ->withInput();
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logoutUser();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
