<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceApiController extends Controller
{
    // GET - All Attendance
    public function index()
    {
        $attendance = Attendance::with('employee.user')
            ->latest()
            ->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Attendance list',
            'data' => $attendance
        ]);
    }

    // GET - Single Attendance
    public function show($id)
    {
        $attendance = Attendance::with('employee.user')
            ->find($id);

        if (!$attendance) {
            return response()->json([
                'status' => false,
                'message' => 'Attendance not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Attendance details',
            'data' => $attendance
        ]);
    }

    // POST - Add Attendance
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employee,id',
            'attendance_date' => 'required|date',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'status' => 'required|in:Present,Absent,Half Day,Leave',
            'remarks' => 'nullable|string'
        ]);

        $exists = Attendance::where('employee_id', $request->employee_id)
            ->where('attendance_date', $request->attendance_date)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Attendance already exists for this date'
            ], 422);
        }

        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'attendance_date' => $request->attendance_date,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => $request->status,
            'remarks' => $request->remarks
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Attendance added successfully',
            'data' => $attendance
        ], 201);
    }

    // PUT - Update Attendance
    public function update(Request $request, $id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json([
                'status' => false,
                'message' => 'Attendance not found'
            ], 404);
        }

        $request->validate([
            'employee_id' => 'required|exists:employee,id',
            'attendance_date' => 'required|date',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'status' => 'required|in:Present,Absent,Half Day,Leave',
            'remarks' => 'nullable|string'
        ]);

        $attendance->update([
            'employee_id' => $request->employee_id,
            'attendance_date' => $request->attendance_date,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => $request->status,
            'remarks' => $request->remarks
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Attendance updated successfully',
            'data' => $attendance
        ]);
    }

    // DELETE - Attendance
    public function destroy($id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json([
                'status' => false,
                'message' => 'Attendance not found'
            ], 404);
        }

        $attendance->delete();

        return response()->json([
            'status' => true,
            'message' => 'Attendance deleted successfully'
        ]);
    }
}
