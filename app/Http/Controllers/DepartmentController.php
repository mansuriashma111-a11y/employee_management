<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    // Add Department Page
    public function department()
    {
        return view('admin.department.add_department');
    }


    // Store Department
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'description' => 'nullable|string',
        ]);

        Department::create([
            'department_name' => $request->department_name,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        // AJAX request ke liye JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Department added successfully!'
            ]);
        }

        return redirect()
            ->route('admin.department.list')
            ->with('success', 'Department added successfully!');
    }


    // Department List
    public function list()
    {
        $departments = Department::latest()->get();

        return view(
            'admin.department.list',
            compact('departments')
        );
    }


    // Delete Department
    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        $department->delete();

        // AJAX request ke liye JSON response
     

        return redirect()
            ->route('admin.department.list')
            ->with('success', 'Department deleted successfully.');
    }


    // Edit Department
    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view(
            'admin.department.edit',
            compact('department')
        );
    }


    // Update Department
    public function update(Request $request, $id)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'description' => 'nullable|string',
        ]);

        $department = Department::findOrFail($id);

        $department->update([
            'department_name' => $request->department_name,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Department updated successfully.'
            ]);
        }

        return redirect()
            ->route('admin.department.list')
            ->with('success', 'Department updated successfully.');
    }


    // Change Department Status
    public function status($id)
    {
        $department = Department::findOrFail($id);

        $department->status = $department->status == 1 ? 0 : 1;

        $department->save();

        // AJAX request ke liye JSON response
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Department status updated successfully.',
                'status' => $department->status
            ]);
        }

        return redirect()
            ->route('admin.department.list')
            ->with('success', 'Department status updated successfully.');
    }


    // Search Department
    public function search(Request $request)
    {
        $search = $request->search;

        $departments = Department::where(function ($query) use ($search) {

                $query->where(
                    'department_name',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'description',
                    'like',
                    '%' . $search . '%'
                );

            })
            ->latest()
            ->get();

        $html = '';

        if ($departments->count() > 0) {

            foreach ($departments as $department) {

                /*
                |--------------------------------------------------------------------------
                | Status Button
                |--------------------------------------------------------------------------
                */

                if ($department->status == 1) {

                    $statusButton = '
                        <form
                            action="' . route(
                                'admin.department.status',
                                $department->id
                            ) . '"
                            method="POST"
                            class="d-inline">

                            ' . csrf_field() . '
                            ' . method_field('PATCH') . '

                            <button
                                type="submit"
                                class="btn btn-sm btn-success">

                                <i class="bi bi-check-circle"></i>
                                Active

                            </button>

                        </form>
                    ';

                } else {

                    $statusButton = '
                        <form
                            action="' . route(
                                'admin.department.status',
                                $department->id
                            ) . '"
                            method="POST"
                            class="d-inline">

                            ' . csrf_field() . '
                            ' . method_field('PATCH') . '

                            <button
                                type="submit"
                                class="btn btn-sm btn-danger">

                                <i class="bi bi-x-circle"></i>
                                Inactive

                            </button>

                        </form>
                    ';
                }


                /*
                |--------------------------------------------------------------------------
                | Created Date
                |--------------------------------------------------------------------------
                */

                $createdAt = $department->created_at
                    ? $department->created_at->format('d M Y')
                    : '-';


                /*
                |--------------------------------------------------------------------------
                | Department Row
                |--------------------------------------------------------------------------
                */

                $html .= '

                <tr>

                    <!-- ID -->
                    <td class="fw-semibold">
                        ' . $department->id . '
                    </td>


                    <!-- Department Name -->
                    <td>

                        <div class="table-media">

                            <div
                                class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">

                                ' . strtoupper(
                                    substr(
                                        $department->department_name,
                                        0,
                                        1
                                    )
                                ) . '

                            </div>

                            <span class="fw-semibold">

                                ' . e(
                                    $department->department_name
                                ) . '

                            </span>

                        </div>

                    </td>


                    <!-- Description -->
                    <td>

                        ' . e(
                            $department->description ?? '-'
                        ) . '

                    </td>


                    <!-- Status -->
                    <td>

                        ' . $statusButton . '

                    </td>


                    <!-- Created At -->
                    <td>

                        ' . $createdAt . '

                    </td>


                    <!-- Actions -->
                    <td class="text-end">


                        <!-- Delete -->

                        <form
                            action="' . route(
                                'admin.department.delete',
                                $department->id
                            ) . '"
                            method="POST"
                            class="d-inline">

                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '

                            <button
                                type="button"
                                class="btn btn-sm btn-danger deleteBtn"
                                data-message="Are you sure you want to delete this department?">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>


                        <!-- Edit -->

                        <a
                            href="' . route(
                                'admin.department.edit',
                                $department->id
                            ) . '"
                            class="btn btn-sm btn-primary">

                            <i class="bi bi-pencil"></i>

                        </a>


                    </td>

                </tr>

                ';
            }

        } else {

            $html = '
                <tr>

                    <td
                        colspan="6"
                        class="text-center py-4 text-muted">

                        No departments found.

                    </td>

                </tr>
            ';
        }


        return response()->json([
            'html' => $html
        ]);
    }
}