<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\BlogController;



Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && ($user->hasRole('admin') || $user->hasRole('asisten'))) {
        return view('dashboardAdmin');
    }
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware(['auth'])->group(function () {
    // user
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/items', [LoanController::class, 'list'])->name('users.list');
    Route::post('/users/items', [LoanController::class, 'store'])->name('users.store.loan');
    Route::get('/users/history', [LoanController::class, 'history'])->name('users.history');
    
    // item
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::patch('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

    // category
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

    // blog
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::patch('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    
    // loan
    Route::get('/loans', [LoanController::class, 'indexSubmited'])->name('loans.submited');
    Route::get('/loans/responded', [LoanController::class, 'indexResponded'])->name('loans.responded');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    Route::patch('/loans/{loan}', [LoanController::class, 'update'])->name('loans.update');
    Route::delete('/loans/{loan}', [LoanController::class, 'destroy'])->name('loans.destroy');

    // user detail
    Route::get('/user/detail', [UserController::class, 'detail'])->name('user.detail');

});


require __DIR__.'/auth.php';
