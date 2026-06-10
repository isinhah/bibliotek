<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            $this->authService->attemptLogin($request->toDTO());

            return redirect()->intended('/');
        } catch (Exception $e) {
            return back()
                ->withErrors(['email' => $e->getMessage()])
                ->onlyInput('email');
        }
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        try {
            $this->authService->registerUser($request->toDTO());

            return redirect()->route('home')
                ->with('success', 'Cadastro realizado com sucesso!');
        } catch (Exception $e) {
            return back()
                ->withErrors(['email' => 'Não foi possível realizar o cadastro. Tente novamente.', 'error_detail' => $e->getMessage()]);
        }
    }

    public function logout(): RedirectResponse
    {
        $this->authService->logoutUser();

        return redirect()->route('home');
    }
}
