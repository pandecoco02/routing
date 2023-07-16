<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TransactionTypeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ApplicantController;
use App\Http\Controllers\Api\OccupationalPermitController;
use App\Http\Controllers\Api\EmploymentTypeController;


Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('/setpassword', [AuthController::class, 'storePassword']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::resource('/roles', RoleController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/applicants',ApplicantController::class );
    Route::resource('/permits',OccupationalPermitController::class );
    Route::resource('/types',EmploymentTypeController::class );
});
