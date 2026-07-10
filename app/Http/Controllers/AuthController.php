<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\RedirectResponse;
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

            return redirect()->intended('/');
        } catch (Exception $e) {
            return back()
                ->withErrors(['email' => $e->getMessage()])
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
                    'email' => 'Não foi possível realizar o cadastro. Tente novamente.',
                    'error_detail' => $e->getMessage()
                ])
                ->withInput();
        }
    }

    public function logout(): RedirectResponse
    {
        $this->authService->logoutUser();

        return redirect()->route('home');
    }
}
