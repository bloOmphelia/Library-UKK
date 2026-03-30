<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('login'));

// ─── Auth Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Auth: Complete Register (setelah login, belum lengkapi profil)
Route::middleware('auth')->group(function () {
    Route::get('/register/complete', [RegisterController::class, 'completeIndex'])->name('register.complete');
    Route::put('/register/complete', [RegisterController::class, 'completeUpdate'])->name('register.update');

    Route::get('/notifications/mark-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();})->name('mark-notifications-read');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Books
        Route::resource('books', BookController::class)
            ->except(['show'])
            ->names([
                'index'   => 'admin.books',
                'create'  => 'admin.books.create',
                'store'   => 'admin.books.store',
                'edit'    => 'admin.books.edit',
                'update'  => 'admin.books.update',
                'destroy' => 'admin.books.destroy',
            ]);

        Route::get('/books/{book}', [BookController::class, 'adminShow'])->name('admin.books.show');
        Route::patch('/books/{book}/status', [BookController::class, 'updateStatus'])->name('admin.books.updateStatus');

        // Category 
        Route::resource('category', CategoryController::class)
            ->except(['show'])
            ->names([
                'index'   => 'admin.category',
                'create'  => 'admin.category.create',
                'store'   => 'admin.category.store',
                'edit'    => 'admin.category.edit',
                'update'  => 'admin.category.update',
                'destroy' => 'admin.category.destroy',
            ]);

        // Transactions
        Route::resource('transactions', AdminTransactionController::class)
            ->except(['show'])
            ->names([
                'index'   => 'admin.transactions',
                'create'  => 'admin.transactions.create',
                'store'   => 'admin.transactions.store',
                'edit'    => 'admin.transactions.edit',
                'update'  => 'admin.transactions.update',
                'destroy' => 'admin.transactions.destroy',
            ]);

        Route::patch('/transactions/{id}/approve', [AdminTransactionController::class, 'approve'])
            ->name('admin.transactions.approve');
        Route::patch('/transactions/{id}/reject', [AdminTransactionController::class, 'reject'])
            ->name('admin.transactions.reject');

        Route::delete('users/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('admin.users.bulkDestroy');
        
        // Users 
        Route::resource('users', UserController::class)
            ->except(['show'])
            ->names([
                'index'   => 'admin.users',
                'create'  => 'admin.users.create',
                'store'   => 'admin.users.store',
                'edit'    => 'admin.users.edit',
                'update'  => 'admin.users.update',
                'destroy' => 'admin.users.destroy',
            ]);

        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    });

Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
        Route::get('/list-books', [BookController::class, 'student'])->name('student.books');
        Route::get('/books/{book}', [BookController::class, 'show'])->name('student.books.show');

        // Transactions student
        Route::get('/transactions', [TransactionController::class, 'index'])->name('student.transactions');
        Route::post('/transactions/borrow', [TransactionController::class, 'borrow'])->name('student.transactions.borrow');
        Route::get('/transactions/return', [TransactionController::class, 'returnIndex'])->name('student.transactions.returnIndex');
        Route::patch('/transactions/{transaction}/return', [TransactionController::class, 'return'])->name('student.transactions.return');

        // Profile student
        Route::get('/profile', [ProfileController::class, 'index'])->name('student.profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('student.profile.update');
    });