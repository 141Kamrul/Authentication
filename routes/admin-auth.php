<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\RegisterController;
use App\Http\Controllers\Auth\Admin\LoginController;

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])
        ->name('admin.register');

    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])
        ->name('admin.login');

    Route::post('login', [LoginController::class, 'store']);

    
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    
    Route::get('/dashboard', function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('admin.logout');
});
