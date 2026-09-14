<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\Leave;
class EmployeeDashboardController extends Controller
{
    //

     public function index()
    {
        $userId = session('user_id');

        $employee = Employee::with('department')
            ->where('user_id', $userId)
            ->first();

        return view('employee.dashboard', compact('employee'));
    }

    public function employeeAttendance(){

        $userId = session('user_id');

        $employee = Employee::where('user_id', $userId)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }

        $attendanceRecords = Attendance::where('employee_id', $employee->id)
            ->orderBy('attendance_date', 'desc')
            ->get();

        return view('employee.attendance', compact('attendanceRecords'));
    }
    public function myLeave()
{
    $userId = session('user_id');

    $employee = Employee::where('user_id', $userId)->first();

    if (!$employee) {
        return redirect()->back()->with('error', 'Employee not found');
    }

    $leaves = Leave::where('employee_id', $employee->id)
        ->orderBy('from_date', 'desc')
        ->get();

    return view('employee.my_leave', compact('leaves'));
}

public function applyLeave()
{
    return view('employee.apply_leave');
}





public function storeLeave(Request $request)
{
    $request->validate([
        'leave_type' => 'required',
        'from_date' => 'required|date',
        'to_date' => 'required|date|after_or_equal:from_date',
        'reason' => 'required',
    ]);

    $userId = session('user_id');

    $employee = Employee::where('user_id', $userId)->first();

    if (!$employee) {
        return redirect()->back()->with('error', 'Employee not found');
    }

    Leave::create([
        'employee_id' => $employee->id,
        'leave_type' => $request->leave_type,
        'from_date' => $request->from_date,
        'to_date' => $request->to_date,
        'reason' => $request->reason,
    ]);

    return redirect()
        ->route('employee.my_leave')
        ->with('success', 'Leave applied successfully.');
}












}
