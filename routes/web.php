<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\EmployeeDashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// ==========================================================
// HOME
// ==========================================================

Route::get('/', function () {
    return view('welcome');
});


// ==========================================================
// AUTH
// ==========================================================

// Login Page
Route::get('/login', function () {
    return view('auth.login');
});

// Register Page
Route::get('/register', function () {
    return view('auth.register');
});

// Register
Route::post('/register', [UserController::class, 'register'])
    ->name('register.store');

// Login
Route::post('/login', [UserController::class, 'login'])
    ->name('login.store');

// Logout
Route::get('/logout', [UserController::class, 'logout'])
    ->name('logout');


// ==========================================================
// PROFILE
// ==========================================================

Route::get('/profile', [UserController::class, 'profile'])
    ->name('profile');

Route::get('/profile/edit', [UserController::class, 'editProfile'])
    ->name('profile.edit');

Route::post('/profile/update', [UserController::class, 'updateProfile'])
    ->name('profile.update');


// ==========================================================
// ADMIN ROUTES
// ==========================================================

Route::middleware('admin')->group(function () {


    // ======================================================
    // ADMIN DASHBOARD
    // ======================================================

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');


    // ======================================================
    // EMPLOYEE STATUS
    // ======================================================

    Route::patch('/employees/{employee}/status',
        [EmployeeController::class, 'status'])
        ->name('employees.status');


    // ======================================================
    // EMPLOYEE MANAGEMENT
    // ======================================================

    // Employee List
    Route::get('/admin/employee/list',
        [EmployeeController::class, 'index'])
        ->name('admin.employee.list');


    // Add Employee Page
    Route::get('/admin/employee/add_employee',
        [EmployeeController::class, 'create'])
        ->name('admin.employee.create');


    // Store Employee
    Route::post('/admin/employee/add_employee',
        [EmployeeController::class, 'store'])
        ->name('employee.store');


    // Edit Employee
    Route::get('/admin/employee/edit/{id}',
        [EmployeeController::class, 'edit'])
        ->name('admin.employee.edit');


    // Update Employee
    Route::put('/admin/employee/update/{id}',
        [EmployeeController::class, 'update'])
        ->name('admin.employee.update');


    // Delete Employee
    Route::delete('/admin/employee/delete/{id}',
        [EmployeeController::class, 'destroy'])
        ->name('admin.employee.delete');


    // Search Employee
    Route::get('/admin/employee/search',
        [EmployeeController::class, 'search'])
        ->name('admin.employee.search');



    // ======================================================
    // DEPARTMENT MANAGEMENT
    // ======================================================

    // Add Department Page
    Route::get('/admin/department/department',
        [DepartmentController::class, 'department'])
        ->name('admin.department.department');


    // Store Department
    Route::post('/admin/department/add_department',
        [DepartmentController::class, 'store'])
        ->name('admin.department.store');


    // Department List
    Route::get('/admin/department/list',
        [DepartmentController::class, 'list'])
        ->name('admin.department.list');


    // Search Department
    Route::get('/admin/department/search',
        [DepartmentController::class, 'search'])
        ->name('admin.department.search');


    // Department Status
    Route::patch('/admin/department/status/{id}',
        [DepartmentController::class, 'status'])
        ->name('admin.department.status');


    // Edit Department
    Route::get('/admin/department/edit/{id}',
        [DepartmentController::class, 'edit'])
        ->name('admin.department.edit');


    // Update Department
    Route::put('/admin/department/update/{id}',
        [DepartmentController::class, 'update'])
        ->name('admin.department.update');


    // Delete Department
    Route::delete('/admin/department/delete/{id}',
        [DepartmentController::class, 'destroy'])
        ->name('admin.department.delete');



    // ======================================================
    // ATTENDANCE MANAGEMENT
    // ======================================================

    // Attendance List
    Route::get('/admin/attendance',
        [AttendanceController::class, 'index'])
        ->name('admin.attendance.list');


    // Add Attendance Page
    Route::get('/admin/attendance/create',
        [AttendanceController::class, 'create'])
        ->name('admin.attendance.create');


    // Store Attendance
    Route::post('/admin/attendance',
        [AttendanceController::class, 'store'])
        ->name('admin.attendance.store');


    // Search Attendance
    Route::get('/admin/attendance/search',
        [AttendanceController::class, 'search'])
        ->name('admin.attendance.search');


    // Edit Attendance
    Route::get('/admin/attendance/edit/{id}',
        [AttendanceController::class, 'edit'])
        ->name('admin.attendance.edit');


    // Update Attendance
    Route::put('/admin/attendance/update/{id}',
        [AttendanceController::class, 'update'])
        ->name('admin.attendance.update');


    // Delete Attendance
    Route::delete('/admin/attendance/delete/{id}',
        [AttendanceController::class, 'delete'])
        ->name('admin.attendance.delete');



    // ======================================================
    // LEAVE MANAGEMENT - ADMIN
    // ======================================================

    // Leave List
    Route::get('/admin/leave',
        [LeaveController::class, 'index'])
        ->name('admin.leave.list');


    // Add Leave Page
    Route::get('/admin/leave/create',
        [LeaveController::class, 'create'])
        ->name('admin.leave.create');


    // Store Leave
    Route::post('/admin/leave',
        [LeaveController::class, 'store'])
        ->name('admin.leave.store');


    // Edit Leave
    Route::get('/admin/leave/edit/{id}',
        [LeaveController::class, 'edit'])
        ->name('admin.leave.edit');


    // Update Leave
    Route::put('/admin/leave/update/{id}',
        [LeaveController::class, 'update'])
        ->name('admin.leave.update');


    // Leave Status
    Route::patch('/admin/leave/status/{id}',
        [LeaveController::class, 'status'])
        ->name('admin.leave.status');


    // Delete Leave
    Route::delete('/admin/leave/delete/{id}',
        [LeaveController::class, 'delete'])
        ->name('admin.leave.delete');

});



// ==========================================================
// EMPLOYEE DASHBOARD
// ==========================================================

Route::middleware('employee')->group(function () {


    // Employee Dashboard
    Route::get('/employee/dashboard',
        [EmployeeDashboardController::class, 'index'])
        ->name('employee.dashboard');


    // Employee Attendance
    Route::get('/employee/attendance',
        [EmployeeDashboardController::class, 'employeeAttendance'])
        ->name('employee.attendance');


    // My Leave
    Route::get('/employee/my-leave',
        [EmployeeDashboardController::class, 'myLeave'])
        ->name('employee.my_leave');


    // Apply Leave Page
    Route::get('/employee/apply-leave',
        [EmployeeDashboardController::class, 'applyLeave'])
        ->name('employee.apply_leave');


    // Store Employee Leave
    Route::post('/employee/apply-leave',
        [EmployeeDashboardController::class, 'storeLeave'])
        ->name('employee.store_leave');

});