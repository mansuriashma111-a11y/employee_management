<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Total Employees
        $totalEmployees = DB::table('users')
            ->where('role', 'employee')
            ->count();

        // Active Employees
        $activeEmployees = DB::table('users')
            ->where('role', 'employee')
            ->where('status', 1)
            ->count();

        // Inactive Employees
        $inactiveEmployees = DB::table('users')
            ->where('role', 'employee')
            ->where('status', 0)
            ->count();

        // Total Departments
        $totalDepartments = DB::table('departments')
            ->where('status', 1)
            ->count();

        // Recent Employees
        $recentEmployees = DB::table('employee')
            ->join('users', 'employee.user_id', '=', 'users.id')
            ->leftJoin(
                'departments',
                'employee.department_id',
                '=',
                'departments.id'
            )
            ->select(
                'users.name',
                'users.email',
                'users.status',
                'departments.department_name',
                'employee.designation',
                'employee.salary'
            )
            ->orderBy('employee.id', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEmployees',
            'activeEmployees',
            'inactiveEmployees',
            'totalDepartments',
            'recentEmployees'
        ));
    }
}