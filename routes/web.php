<?php

use App\Http\Controllers\ProfileController;
use App\Jobs\TranslateJob;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\EmployerController;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('jobs',JobController::class)->only([
    'index','show','create','store','edit','update','destroy'
]);
Route::controller(JobController::class)->group(function() {
    Route::get('/jobs', 'index');
    Route::get('/jobs/create','create');
    Route::post('/jobs','store');
    Route::get('/jobs/{job}','show');
    Route::get('/jobs/{job}/edit','edit');  
    Route::patch('/jobs/{job}','update')->middleware(['auth','can:edit,job']);
    Route::delete('/jobs/{job}','destroy');
});

Route::resource('employers',EmployerController::class)->only([
    'index','show'
]);
Route::controller(EmployerController::class)->group(function() {
    Route::get('/employers','index');
    Route::get('/emmployers/employer','show');
});

Route::get('/test',function(){
    
    // Mail::to('jeffrey@laracasts.com')->send(new \App\Mail\JobPosted());
    // return 'DOne';
    // return new App\Mail\JobPosted() ;
    // dispatch(function(){
    //     logger('hello from queue');
    // })->delay(5);
    $job=\App\Models\Job::first();
    TranslateJob::dispatch( $job);
    return "Done";
});

require __DIR__.'/auth.php';
