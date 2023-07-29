<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ApplicantController;
use App\Http\Controllers\Api\OccupationalPermitController;
use App\Http\Controllers\Api\EmploymentTypeController;
use App\Http\Controllers\Api\SignatoryController;


Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('/setpassword', [AuthController::class, 'storePassword']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::resource('/roles', RoleController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/applicants',ApplicantController::class);
    Route::resource('/permits',ApplicantController::class);
    Route::resource('/types',EmploymentTypeController::class);
    Route::resource('/signatories',SignatoryController::class);
});
