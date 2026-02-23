<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () { return redirect()->route('login');});


Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/books', [BookController::class, 'index'])->name('admin.books');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/books/create', [BookController::class, 'create'])->name('admin.books.create');
        Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');
        Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('admin.books.edit');
        Route::put('/books/{id}', [BookController::class, 'update'])->name('admin.books.update');
        Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('admin.books.destroy');

        Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
        Route::post('/category', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/category/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

        Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('admin.transactions');
        Route::get('/transactions/create', [AdminTransactionController::class, 'create'])->name('admin.transactions.create');
        Route::post('/transactions', [AdminTransactionController::class, 'store'])->name('admin.transactions.store');
        Route::get('/transactions/{id}/edit', [AdminTransactionController::class, 'edit'])->name('admin.transactions.edit');
        Route::put('/transactions/{id}', [AdminTransactionController::class, 'update'])->name('admin.transactions.update');
        Route::delete('/transactions/{id}', [AdminTransactionController::class, 'destroy'])->name('admin.transactions.destroy');

        Route::patch('/transactions/{id}/approve', [AdminTransactionController::class, 'approve'])->name('admin.transactions.approve');
        Route::patch('/transactions/{id}/reject', [AdminTransactionController::class, 'reject'])->name('admin.transactions.reject');

        Route::get('/users', [UserController::class, 'index'])->name('admin.users');
        Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::prefix('student')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
        Route::get('/list-books', [BookController::class, 'student'])->name('student.books');

        Route::get('/transactions', [TransactionController::class, 'index'])->name('student.transactions');
        Route::post('/transactions/borrow', [TransactionController::class, 'borrow'])->name('student.transactions.borrow');
        Route::get('/transactions/return', [TransactionController::class, 'returnIndex'])->name('student.transactions.returnIndex');
        Route::patch('/transactions/{transaction}/return', [TransactionController::class, 'return'])->name('student.transactions.return');
    });

});
