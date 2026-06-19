<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserLoanController;
use Illuminate\Support\Facades\Route;

// CATALOGO

// PÁGINA INICIAL
Route::get('/', [HomeController::class, 'index'])->name('home');

// VISUALIZAÇÃO DE CATEGORIAS
Route::get('categories', [CategoryController::class, 'indexPublic'])->name('categories.public');
Route::get('categories/{category}/books', [BookController::class, 'index'])->name('categories.books.index');

// VISUALIZAÇÃO DE AUTORES
Route::get('authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('authors/{author}/books', [AuthorController::class, 'books'])->name('authors.books.index');

// VISITANTES
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// LOGOUT
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// LEITOR AUTENTICADO
Route::middleware(['auth'])->group(function () {
    Route::get('my-loans', [UserLoanController::class, 'index'])->name('loans.index');
    Route::post('/books/{book}/loan', [LoanController::class, 'store'])->name('loans.store');
});
