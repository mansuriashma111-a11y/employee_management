<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentApiController extends Controller
{
    // GET - All Departments
    public function index()
    {
        $departments = Department::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Departments fetched successfully',
            'data' => $departments
        ], 200);
    }

    // POST - Create Department
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'status' => 'required',
            'description' => 'nullable|string'
        ]);

        $department = Department::create([
            'department_name' => $request->department_name,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Department created successfully',
            'data' => $department
        ], 201);
    }

    // GET - Single Department
    public function show($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'status' => false,
                'message' => 'Department not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Department fetched successfully',
            'data' => $department
        ], 200);
    }

    // PUT - Update Department
    public function update(Request $request, $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'status' => false,
                'message' => 'Department not found'
            ], 404);
        }

        $request->validate([
            'department_name' => 'required|string|max:255',
            'status' => 'required',
            'description' => 'nullable|string'
        ]);

        $department->update([
            'department_name' => $request->department_name,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Department updated successfully',
            'data' => $department
        ], 200);
    }

    // DELETE - Delete Department
    public function destroy($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'status' => false,
                'message' => 'Department not found'
            ], 404);
        }

        $department->delete();

        return response()->json([
            'status' => true,
            'message' => 'Department deleted successfully'
        ], 200);
    }
}