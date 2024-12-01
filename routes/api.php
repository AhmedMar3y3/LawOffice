<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CaseCategryController;
use App\Http\Controllers\API\CaseController;
use App\Http\Controllers\API\CustomerCategryController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\AttachmentController;
use App\Http\Controllers\API\SessionController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\GettingController;

//////////////////////////  User Public Routes  //////////////////////////
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

//////////////////////////  User Private Routes  //////////////////////////
Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        //Customer category routes
        Route::get('/categories', [CustomerCategryController::class, 'index']);
        Route::post('/category', [CustomerCategryController::class, 'store']);
        Route::delete('/category/{category}', [CustomerCategryController::class, 'destroy']);

        //Customer routes
        Route::get('/customers', [CustomerController::class, 'index']);
        Route::get('/customer/{customer}', [CustomerController::class, 'show']);
        Route::post('/store-customer', [CustomerController::class, 'store']);
        Route::post('/update-customer/{customer}', [CustomerController::class, 'update']);
        Route::delete('/customer/{customer}', [CustomerController::class, 'destroy']);

        //Case category routes
        Route::get('/case-categories', [CaseCategryController::class, 'index']);
        Route::post('/case-category', [CaseCategryController::class, 'store']);
        Route::delete('/case-category/{category}', [CaseCategryController::class, 'destroy']);

        //Case routes
        Route::prefix('/customer/{customer}')->group(function () {
                Route::get('/cases', [CaseController::class, 'index']);
                Route::get('/case/{case}', [CaseController::class, 'show']);
                Route::post('/store-case', [CaseController::class, 'store']);
                Route::post('/update-case/{case}', [CaseController::class, 'update']);
                Route::delete('/case/{case}', [CaseController::class, 'destroy']);
        
                // Attachment routes
                Route::prefix('/case/{case}')->group(function () {
                    Route::get('/attachments', [AttachmentController::class, 'index']);
                    Route::get('/attachment/{attachment}', [AttachmentController::class, 'show']);
                    Route::post('/store-attachment', [AttachmentController::class, 'store']);
                    Route::post('/update-attachment/{attachment}', [AttachmentController::class, 'update']);
                    Route::delete('/attachment/{attachment}', [AttachmentController::class, 'destroy']);
               // Session routes
                    Route::get('/sessions', [SessionController::class, 'index']);
                    Route::get('/session/{session}', [SessionController::class, 'show']);
                    Route::post('/store-session', [SessionController::class, 'store']);
                    Route::post('/update-session/{session}', [SessionController::class, 'update']);
                    Route::delete('/session/{session}', [SessionController::class, 'destroy']);

               // Payment routes
                    Route::get('/payments', [PaymentController::class, 'index']);
                    Route::get('/payment/{payment}', [PaymentController::class, 'show']);
                    Route::post('/store-payment', [PaymentController::class, 'store']);
                    Route::post('/update-payment/{payment}', [PaymentController::class, 'update']);
                    Route::delete('/payment/{payment}', [PaymentController::class, 'destroy']);
                });
});

              //getting routes
                    Route::get('/sessions', [GettingController::class, 'getAllSessions']);
                    Route::get('/payments', [GettingController::class, 'getAllPayments']);
                    Route::get('/cases', [GettingController::class, 'getAllCases']);
                    Route::get('/attachments', [GettingController::class, 'getAllAttachments']);
});