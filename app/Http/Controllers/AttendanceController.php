<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    // ==================== ATTENDANCE LIST ====================

    public function index()
    {
        $attendances = Attendance::with('employee')
            ->orderBy('attendance_date', 'desc')
            ->paginate(10);

        return view('admin.attendance.list', compact('attendances'));
    }


    // ==================== CREATE PAGE ====================

    public function create()
    {
        $employees = Employee::with('user')->get();

        return view('admin.attendance.create', compact('employees'));
    }


    // ==================== STORE ====================

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employee,id',
            'attendance_date' => 'required|date',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'status' => 'required|in:Present,Absent,Half Day,Leave',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please check the form fields.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Duplicate attendance check
        $exists = Attendance::where('employee_id', $request->employee_id)
            ->where('attendance_date', $request->attendance_date)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Attendance already exists for this employee on this date.'
            ], 422);
        }

        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'attendance_date' => $request->attendance_date,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Attendance marked successfully.',
            'data' => $attendance
        ]);
    }


    // ==================== SEARCH ====================

    public function search(Request $request)
    {
        $query = Attendance::with('employee');

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('attendance_date')) {
            $query->whereDate(
                'attendance_date',
                $request->attendance_date
            );
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query
            ->orderBy('attendance_date', 'desc')
            ->paginate(10);

        return view(
            'admin.attendance.list',
            compact('attendances')
        );
    }


    // ==================== EDIT PAGE ====================

    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);

        $employees = Employee::with('user')->get();

        return view(
            'admin.attendance.edit',
            compact('attendance', 'employees')
        );
    }


    // ==================== UPDATE ====================

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            'attendance_date' => 'required|date',

            'check_in' => 'nullable',

            'check_out' => 'nullable',

            'status' => 'required|in:Present,Absent,Half Day,Leave',

            'remarks' => 'nullable|string',
        ]);


        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Please check the form fields.',
                'errors' => $validator->errors()
            ], 422);
        }


        $attendance = Attendance::findOrFail($id);


        $attendance->update([

            'attendance_date' => $request->attendance_date,

            'check_in' => $request->check_in,

            'check_out' => $request->check_out,

            'status' => $request->status,

            'remarks' => $request->remarks,

        ]);


        return response()->json([

            'status' => true,

            'message' => 'Attendance updated successfully.',

            'data' => $attendance

        ]);
    }


    // ==================== DELETE ====================

    public function delete($id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->delete();

       return redirect()
            ->route('admin.attendance.list')
            ->with('success', 'Department deleted successfully.');
    }
    }
