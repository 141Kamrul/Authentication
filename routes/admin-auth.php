<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\RegisterController;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\DataTableController;

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

    Route::get('/charts',function(){
        return view('admin.charts');
    })->name('admin.charts');

    // Route::get('/data', function(){
    //     return view('admin.data');
    // })->name('admin.data');

    Route::controller(DataTableController::class)->group(function(){
        Route::get('/index','index')->name('admin.index');

        Route::post('/create', 'create')->name('admin.create');

        Route::patch('/edit', 'edit')->name('admin.edit');

        Route::delete('/delete/{employee}', 'destroy')->name('admin.destroy');
    });

});
