<?php

use App\Http\Controllers\Admin\AdminmainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'rolemanager:customer'])->name('dashboard');


//route for admin 

Route::middleware(['auth', 'verified', 'rolemanager:admin'])->group(function () {

    Route::controller(AdminmainController::class)->group(function () {

        Route::prefix('admin')->group(function () { //prefix for /admin
            Route::get('/dashboard','index')->name('admin');
        });

    });


});




Route::get('vendor/dashboard', function () {
    return view('vendor');
})->middleware(['auth', 'verified', 'rolemanager:vendor'])->name('vendor');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
