<?php

use App\Http\Controllers\DataTableController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PositionController;



Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::controller(DataTableController::class)->group(function(){
        Route::get('/employee/index','index')->name('admin.employee_index');

        Route::get('/create', 'create')->name('admin.create');
        Route::post('/employee/store', 'store')->name('admin.store');

        Route::get('/edit/{employee}', 'edit')->name('admin.edit');
        Route::put('/update/{employee}', 'update')->name('admin.update');

        Route::delete('/{employee}', 'destroy')->name('admin.destroy');
    });


    Route::controller(OfficeController::class)->group(function(){
        Route::get('/office/index','index')->name('admin.office_index');

        Route::post('/office/store', 'store')->name('admin.office_store');

        Route::get('/office/{office}','show')->name('admin.office_position');
    });

    Route::controller(PositionController::class)->group(function(){
        Route::get('/position/index','index')->name('admin.position_index');

        Route::post('/office/{office}/positions', 'store')->name('admin.positions.store');

        Route::get('/position/{positions}', 'show')->name('admin.position_employees');
    });
});