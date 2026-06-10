<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserLoanController;
use Illuminate\Support\Facades\Route;

// === PÁGINA INICIAL ===
Route::get('/', [HomeController::class, 'index'])->name('home');

// === LOGIN E LOGOUT ===
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// === VISÃO DO USUÁRIO ===

// -- CATEGORIAS
Route::get('categories', [CategoryController::class, 'indexPublic'])->name('categories.public');
Route::get('categories/{category}/books', [BookController::class, 'index'])->name('categories.books.index');

// -- AUTORES
Route::get('authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('authors/{author}/books', [AuthorController::class, 'books'])->name('authors.books.index');
Route::delete('admin/authors/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');

// -- LIVROS
Route::get('books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::put('books/{book}', [BookController::class, 'update'])->name('books.update');

// -- EMPRÉSTIMOS
Route::post('/books/{book}/loan', [LoanController::class, 'store'])
    ->name('loans.store')
    ->middleware('auth');
Route::get('/my-loans', [UserLoanController::class, 'index'])->name('loans.index');

// === PAINEL DO ADMINISTRADOR ===

Route::middleware(['auth', 'role:admin'])->group(function () {

    // -- GERENCIAMENTO DE CATEGORIAS
    Route::get('admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('admin/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('admin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // -- GERENCIAMENTO DE AUTORES
    Route::get('admin/authors', [AuthorController::class, 'indexAdmin'])->name('admin.authors.index');
    Route::post('admin/authors', [AuthorController::class, 'store'])->name('admin.authors.store');
    Route::put('admin/authors/{author}', [AuthorController::class, 'update'])->name('admin.authors.update');
    Route::delete('admin/authors/{author}', [AuthorController::class, 'destroy'])->name('admin.authors.destroy');

    // -- GERENCIAMENTO DE LIVROS
    Route::get('admin/books', [BookController::class, 'indexAdmin'])->name('admin.books.index');
    Route::post('admin/books', [BookController::class, 'store'])->name('admin.books.store');
    Route::put('admin/books/{book}', [BookController::class, 'updateFull'])->name('admin.books.update');
    Route::delete('admin/books/{book}', [BookController::class, 'destroy'])->name('admin.books.destroy');

    // -- GERENCIAMENTO DE EMPRÉSTIMOS
    Route::get('admin/loans', [LoanController::class, 'index'])->name('admin.loans.index');
    Route::post('admin/loans/{id}/pickup', [LoanController::class, 'confirmPickup'])->name('admin.loans.pickup');
    Route::post('admin/loans/{id}/cancel', [LoanController::class, 'cancel'])->name('admin.loans.cancel');
    Route::post('admin/loans/{id}/return', [LoanController::class, 'returnBook'])->name('admin.loans.return');

    // -- IMPORTAÇÃO DA API
    Route::post('categories/{category}/import', [BookController::class, 'importFromAPI'])->name('books.import');
});
