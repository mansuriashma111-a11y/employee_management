<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    // =========================
    // Employee List
    // =========================
    public function index()
    {
        $employees = DB::table('employee')
            ->join('users', 'employee.user_id', '=', 'users.id')
            ->join('departments', 'employee.department_id', '=', 'departments.id')
            ->select(
                'employee.id',
                'employee.user_id',
                'employee.department_id',
                'departments.department_name',
                'employee.designation',
                'employee.salary',
                'users.name',
                'users.email',
                'users.phone',
                'users.status',
                'users.profile_image'
            )
            ->paginate(10);

        return view('admin.employee.list', compact('employees'));
    }


    // =========================
    // Employee Status
    // =========================
    public function status($id)
    {
        $employee = DB::table('employee')
            ->where('id', $id)
            ->first();

        if (!$employee) {
            return back()->with('error', 'Employee not found.');
        }

        DB::table('users')
            ->where('id', $employee->user_id)
            ->update([
                'status' => DB::raw('IF(status = 1, 0, 1)')
            ]);

        return back()->with('success', 'Status updated successfully.');
    }


    // =========================
    // Add Employee Page
    // =========================
    public function create()
    {
        $departments = Department::where('status', 1)->get();

        $users = User::where('role', 'employee')
            ->whereDoesntHave('employee')
            ->get();

        return view(
            'admin.employee.add_employee',
            compact('users', 'departments')
        );
    }


    // =========================
    // Store Employee
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'designation'   => 'required|string|max:255',
            'salary'        => 'required|numeric|min:1',
        ]);

        DB::table('employee')->insert([
            'user_id'       => $request->user_id,
            'department_id' => $request->department_id,
            'designation'   => $request->designation,
            'salary'        => $request->salary,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Employee added successfully!'
        ]);
    }


    // =========================
    // Delete Employee
    // =========================
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        $userId = $employee->user_id;

        $employee->delete();

        User::where('id', $userId)->delete();

        return redirect()
            ->route('admin.employee.list')
            ->with('success', 'Employee deleted successfully.');
    }


    // =========================
    // Edit Employee
    // =========================
    public function edit($id)
    {
        $employee = DB::table('employee')
            ->join('users', 'employee.user_id', '=', 'users.id')
            ->join('departments', 'employee.department_id', '=', 'departments.id')
            ->where('employee.id', $id)
            ->select(
                'employee.id',
                'employee.user_id',
                'employee.department_id',
                'departments.department_name',
                'employee.designation',
                'employee.salary',
                'users.name',
                'users.email',
                'users.profile_image',
                'users.phone'
            )
            ->first();

        if (!$employee) {
            return redirect()
                ->route('admin.employee.list')
                ->with('error', 'Employee not found.');
        }

        // Active departments for edit dropdown
        $departments = Department::where('status', 1)->get();

        return view(
            'admin.employee.edit',
            compact('employee', 'departments')
        );
    }


    // =========================
    // Update Employee
    // =========================
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $user = User::findOrFail($employee->user_id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email',
            'phone'         => 'required|digits:10',
            'department_id' => 'required|exists:departments,id',
            'designation'   => 'required|string|max:255',
            'salary'        => 'required|numeric|min:1',
        ]);

        // =========================
        // Users table update
        // =========================
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        $user->save();


        // =========================
        // Employee table update
        // =========================
        $employee->department_id = $request->department_id;
        $employee->designation = $request->designation;
        $employee->salary = $request->salary;

        $employee->save();


        return response()->json([
            'status'  => true,
            'message' => 'Employee updated successfully!'
        ]);
    }

    // =========================
    // AJAX Employee Search
    // =========================
    public function search(Request $request)
    {
        $search = $request->search;

        $employees = Employee::with(['user', 'department'])
            ->where(function ($query) use ($search) {

                $query->where('designation', 'like', "%$search%")
                    ->orWhere('salary', 'like', "%$search%")

                    // Department name search
                    ->orWhereHas('department', function ($query) use ($search) {

                        $query->where(
                            'department_name',
                            'like',
                            "%$search%"
                        );

                    })

                    // User search
                    ->orWhereHas('user', function ($query) use ($search) {

                        $query->where('name', 'like', "%$search%")
                            ->orWhere('phone', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");

                    });

            })
            ->get();

        $html = '';

        foreach ($employees as $employee) {

            $image = $employee->user->profile_image
                ? asset('uploads/profile/' . $employee->user->profile_image)
                : asset('assets/images/default-profile.png');


            $html .= '
            <tr>
                <td>
                    ' . $employee->id . '
                </td>

                <td>
                    ' . $employee->user->name . '
                </td>

                <td>
                    ' . $employee->user->email . '
                </td>
                 <td>
                    ' . $employee->user->phone . '
                </td>
                <td>
                    <img src="' . $image . '"
                         alt="Profile Image"
                         width="50"
                         height="50"
                         style="object-fit: cover; border-radius: 50%;">
                </td>

                <td>

                    <span class="badge text-bg-info">
                        ' . ($employee->department->department_name ?? '-') . '
                    </span>

                </td>

                <td>
                    ₹' . number_format($employee->salary, 2) . '
                </td>

                <td>
                    ' . $employee->designation . '
                </td>
                 
                    <td>
                     <button type="button"
                     class="btn btn-sm ' . ($employee->user->status == 1 ? 'btn-success' : 'btn-danger') . '">
                  ' . ($employee->user->status == 1 ? 'Active' : 'Inactive') . '
                     </button>
                    
                </td>





                <td class="text-end">

                    <a href="' . route(
                        'admin.employee.edit',
                        $employee->id
                    ) . '"
                       class="btn btn-sm btn-primary">

                        <i class="bi bi-pencil"></i>

                    </a>


                    <form action="' . route(
                        'admin.employee.delete',
                        $employee->id
                    ) . '"
                          method="POST"
                          style="display:inline-block;">

                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '

                        <button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm(\'Are you sure you want to delete this employee?\')">

                            <i class="bi bi-trash"></i>

                        </button>

                    </form>

                </td>

            </tr>';
        }


        if ($employees->isEmpty()) {

            $html = '
            <tr>

                <td colspan="8"
                    class="text-center py-4 text-muted">

                    No employee found

                </td>

            </tr>';
        }


        return response()->json([
            'html' => $html
        ]);
    }
}