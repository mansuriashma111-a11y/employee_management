<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;

class EmployeeApiController extends Controller
{
    // Get all employees
    public function index()
    {
        $employees = Employee::with(['user', 'department'])
            ->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Employees fetched successfully',
            'data' => $employees
        ], 200);
    }


    // Get single employee
    public function show($id)
    {
        $employee = Employee::with(['user', 'department'])
            ->find($id);

        if (!$employee) {
            return response()->json([
                'status' => false,
                'message' => 'Employee not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Employee fetched successfully',
            'data' => $employee
        ], 200);
    }


    // Add employee
    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'designation'   => 'required|string|max:255',
            'salary'        => 'required|numeric|min:1',
        ]);

        $employee = Employee::create([
            'user_id'       => $request->user_id,
            'department_id' => $request->department_id,
            'designation'   => $request->designation,
            'salary'        => $request->salary,
        ]);

        // Load relations
        $employee->load(['user', 'department']);

        return response()->json([
            'status' => true,
            'message' => 'Employee added successfully',
            'data' => $employee
        ], 201);
    }


    // Update employee
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'status' => false,
                'message' => 'Employee not found'
            ], 404);
        }

        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'designation'   => 'required|string|max:255',
            'salary'        => 'required|numeric|min:1',
        ]);

        $employee->update([
            'department_id' => $request->department_id,
            'designation'   => $request->designation,
            'salary'        => $request->salary,
        ]);

        // Load updated relations
        $employee->load(['user', 'department']);

        return response()->json([
            'status' => true,
            'message' => 'Employee updated successfully',
            'data' => $employee
        ], 200);
    }


    // Delete employee
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'status' => false,
                'message' => 'Employee not found'
            ], 404);
        }

        $userId = $employee->user_id;

        // Delete employee
        $employee->delete();

        // Delete related user
        User::where('id', $userId)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Employee deleted successfully'
        ], 200);
    }
}