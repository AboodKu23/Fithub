<?php

use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\RegisterStepOneController;
use App\Http\Controllers\Trainee\RegisterTraineeController;
use App\Http\Controllers\Trainee\TraineeSubscriptionController;
use App\Http\Controllers\Trainee\TrainersIntegrationController;
use App\Http\Controllers\Trainer\RegisterTrainerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('Auth')->group(function () {
    Route::post('/register',[RegisterStepOneController::class,'firstStepRegister']); //Done
    Route::post('/trainee/register', [RegisterTraineeController::class,'register']); //Done
    Route::post('/trainer/register', [RegisterTrainerController::class,'register']);
    Route::post('/trainer/certificate', [RegisterTrainerController::class,'addCertificate']);
    Route::post('/login', [AuthenticatedController::class, 'login']); //Done


    Route::prefix('Email')->group(function () {
        Route::post('/verify-code', [EmailVerificationController::class, 'verify'])
            ->name('verification.verify.code'); //Done
        Route::post('/resend', [EmailVerificationController::class, 'resend'])
            ->middleware('auth:sanctum');
    });
});

//Route::middleware(['auth:sanctum','role:trainee'])->group(function () {
    Route::prefix('Trainee')->group(function () {
        Route::prefix('trainers_integration')->group(function () {
            Route::get('trainers', [TrainersIntegrationController::class, 'getTrainers']);
            Route::get('trainer/{id}', [TrainersIntegrationController::class, 'getTrainer']);
        });

        Route::prefix('subscription_requests')->group(function () {
            Route::post('/send/{id}', [TraineeSubscriptionController::class, 'sendSubscriptionRequest']);
        });
    });
//});


//Route::middleware(['auth:sanctum','role:trainer'])->group(function () {
    Route::prefix('Trainer')->group(function () {

    });
//});
