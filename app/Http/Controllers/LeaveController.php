<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    // =========================
    // Leave List
    // =========================
    public function index()
    {
        $leaves = Leave::with('employee.user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.leave.list', compact('leaves'));
    }


    // =========================
    // Add Leave Form
    // =========================
    public function create()
    {
        $employees = Employee::with('user')->get();

        return view('admin.leave.create', compact('employees'));
    }


    // =========================
    // Store Leave
    // =========================
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'employee_id' => 'required|exists:employee,id',

            'leave_type' => 'required|in:Casual Leave,Sick Leave,Paid Leave,Emergency Leave',

            'from_date' => 'required|date',

            'to_date' => 'required|date|after_or_equal:from_date',

            'reason' => 'nullable|string',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Please check the form fields.',
                'errors' => $validator->errors()
            ], 422);
        }

        $leave = Leave::create([

            'employee_id' => $request->employee_id,

            'leave_type' => $request->leave_type,

            'from_date' => $request->from_date,

            'to_date' => $request->to_date,

            'reason' => $request->reason,

            'status' => 'Pending',

        ]);

        return response()->json([

            'status' => true,

            'message' => 'Leave applied successfully.',

            'data' => $leave

        ]);
    }


    // =========================
    // Edit Leave
    // =========================
    public function edit($id)
    {
        $leave = Leave::findOrFail($id);

        $employees = Employee::with('user')->get();

        return view('admin.leave.edit', compact(
            'leave',
            'employees'
        ));
    }


    // =========================
    // Update Leave
    // =========================
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            'employee_id' => 'required|exists:employee,id',

            'leave_type' => 'required|in:Casual Leave,Sick Leave,Paid Leave,Emergency Leave',

            'from_date' => 'required|date',

            'to_date' => 'required|date|after_or_equal:from_date',

            'reason' => 'nullable|string',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Please check the form fields.',
                'errors' => $validator->errors()
            ], 422);
        }

        $leave = Leave::findOrFail($id);

        $leave->update([

            'employee_id' => $request->employee_id,

            'leave_type' => $request->leave_type,

            'from_date' => $request->from_date,

            'to_date' => $request->to_date,

            'reason' => $request->reason,

        ]);

        return response()->json([

            'status' => true,

            'message' => 'Leave updated successfully.',

            'data' => $leave

        ]);
    }


    // =========================
    // Approve / Reject Leave
    // =========================
    public function status(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            'status' => 'required|in:Pending,Approved,Rejected',

            'admin_remark' => 'nullable|string',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Invalid status.'
            ], 422);
        }

        $leave = Leave::findOrFail($id);

        $leave->update([

            'status' => $request->status,

            'admin_remark' => $request->admin_remark,

        ]);

        return response()->json([

            'status' => true,

            'message' => 'Leave status updated successfully.'

        ]);
    }


    // =========================
    // Delete Leave
    // =========================
    public function delete($id)
    {
        $leave = Leave::findOrFail($id);

        $leave->delete();

       return redirect()
       ->route('admin.leave.list')
       ->with('success', 'leave deleted successfully.');
    }
}