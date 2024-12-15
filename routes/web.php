<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;


//////////////////////////////////Admin Routes//////////////////////////////////

//public routes
Route::get('/', [AuthController::class, 'loadLoginPage'])->name('loginPage');
Route::post('/login-admin', [AuthController::class, 'loginUser'])->name('loginUser');

//protected routes
Route::middleware(['auth.admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/offices', [DashboardController::class, 'loadOffices'])->name('offices.index');
    Route::get('/offices/{id}', [DashboardController::class, 'loadOffice'])->name('offices.show');
    Route::delete('/offices/{id}', [DashboardController::class, 'deleteOffice'])->name('offices.delete');
    Route::post('/offices/approve/{id}', [DashboardController::class, 'approveUser'])->name('offices.approve');
Route::delete('/offices/reject/{id}', [DashboardController::class, 'rejectUser'])->name('offices.reject');


});
