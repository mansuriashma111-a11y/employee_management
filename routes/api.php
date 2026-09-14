<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeApiController;
use App\Http\Controllers\Api\DepartmentApiController;
use App\Http\Controllers\Api\AttendanceApiController;
use App\Http\Controllers\Api\LeaveApiController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Employee APIs

Route::get('/employees', [EmployeeApiController::class, 'index']);

Route::get('/employees/{id}', [EmployeeApiController::class, 'show']);

Route::post('/employees', [EmployeeApiController::class, 'store']);

Route::put('/employees/{id}', [EmployeeApiController::class, 'update']);

Route::delete('/employees/{id}', [EmployeeApiController::class, 'destroy']);


Route::get('/departments', [DepartmentApiController::class, 'index']);
Route::post('/departments', [DepartmentApiController::class, 'store']);
Route::get('/departments/{id}', [DepartmentApiController::class, 'show']);
Route::put('/departments/{id}', [DepartmentApiController::class, 'update']);
Route::delete('/departments/{id}', [DepartmentApiController::class, 'destroy']);

Route::apiResource('attendance', AttendanceApiController::class);
Route::apiResource('leaves', LeaveApiController::class);