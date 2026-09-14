<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveApiController extends Controller
{
    // GET - All Leaves
    public function index()
    {
        $leaves = Leave::latest()->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Leave list',
            'data' => $leaves
        ]);
    }

    // GET - Single Leave
    public function show($id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json([
                'status' => false,
                'message' => 'Leave not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Leave details',
            'data' => $leave
        ]);
    }

    // POST - Apply Leave
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employee,id',
            'leave_type' => 'required|in:Casual Leave,Sick Leave,Paid Leave,Emergency Leave',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required|string'
        ]);

        $leave = Leave::create([
            'employee_id' => $request->employee_id,
            'leave_type' => $request->leave_type,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'reason' => $request->reason
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Leave applied successfully',
            'data' => $leave
        ], 201);
    }

    // PUT - Update Leave
    public function update(Request $request, $id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json([
                'status' => false,
                'message' => 'Leave not found'
            ], 404);
        }

        $request->validate([
            'employee_id' => 'required|exists:employee,id',
            'leave_type' => 'required|in:Casual Leave,Sick Leave,Paid Leave,Emergency Leave',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required|string'
        ]);

        $leave->update([
            'employee_id' => $request->employee_id,
            'leave_type' => $request->leave_type,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'reason' => $request->reason
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Leave updated successfully',
            'data' => $leave
        ]);
    }

    // DELETE - Leave
    public function destroy($id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json([
                'status' => false,
                'message' => 'Leave not found'
            ], 404);
        }

        $leave->delete();

        return response()->json([
            'status' => true,
            'message' => 'Leave deleted successfully'
        ]);
    }
}