@extends('layouts.app')
@include('layouts.auth')

@section('title', 'Department List')

@section('content')

<main class="dashboard-content">

    <div class="container-fluid px-3 px-lg-4 py-4">

        <!-- Page Heading -->
        <div class="page-heading">

            <div class="page-heading-copy">

                <span class="page-icon">
                    <i class="bi bi-building" aria-hidden="true"></i>
                </span>

                <div>
                    <p class="eyebrow mb-1">Data</p>

                    <h1 class="h3 mb-1">
                        Departments
                    </h1>

                    <p class="text-muted mb-0">
                        Manage and search department records.
                    </p>
                </div>

            </div>

        </div>


        <!-- Department Panel -->
        <section class="panel">

            <!-- Header + Search -->
            <div class="panel-header">

                <div>
                    <h2 class="h5 mb-1 section-title">
                        <i class="bi bi-building" aria-hidden="true"></i>
                        <span>Department Table</span>
                    </h2>

                    <p class="text-muted mb-0">
                        Searchable department data.
                    </p>
                </div>

                <!-- Search -->
                <input
                    id="departmentSearch"
                    class="form-control form-control-sm table-search"
                    type="search"
                    placeholder="Search department"
                    aria-label="Search department">

            </div>


            <!-- Department Table -->
            <div class="table-responsive">

                <table class="table align-middle mb-0" id="departmentTable">

                    <thead>
                        <tr>

                            <th>#</th>

                            <th>Department Name</th>

                            <th>Description</th>

                            <th>Status</th>

                            <th>Created At</th>

                            <th class="text-end">
                                Action
                            </th>

                        </tr>
                    </thead>


                    <tbody id="departmentTableBody">

                        @forelse($departments as $department)

                        <tr>

                            <!-- ID -->
                            <td class="fw-semibold">
                                {{ $department->id }}
                            </td>


                            <!-- Department Name -->
                            <td>

                                <div class="table-media">

                                    <div
                                        class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">

                                        {{ strtoupper(substr($department->department_name, 0, 1)) }}

                                    </div>

                                    <span class="fw-semibold">
                                        {{ $department->department_name }}
                                    </span>

                                </div>

                            </td>


                            <!-- Description -->
                            <td>
                                {{ $department->description ?? '-' }}
                            </td>


                            <!-- Status -->
                            <td>

                                <form
                                    action="{{ route('admin.department.status', $department->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('PATCH')

                                    @if($department->status == 1)

                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle"></i>
                                            Active
                                        </button>

                                    @else

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-x-circle"></i>
                                            Inactive
                                        </button>

                                    @endif

                                </form>

                            </td>


                            <!-- Created At -->
                            <td>
                                {{ $department->created_at ? $department->created_at->format('d M Y') : '-' }}
                            </td>


                            <!-- Actions -->
                            <td class="text-end">

                                <!-- Delete -->
                                <form
                                    action="{{ route('admin.department.delete', $department->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-danger deleteBtn"
                                        data-message="Are you sure you want to delete this department?">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>


                                <!-- Edit -->
                                <a
                                    href="{{ route('admin.department.edit', $department->id) }}"
                                    class="btn btn-sm btn-primary">

                                    <i class="bi bi-pencil"></i>

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No departments found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    </div>

</main>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<!-- AJAX Search -->
<script>

$(document).ready(function () {

    $('#departmentSearch').on('keyup', function () {

        let search = $(this).val();

        $.ajax({

            url: "{{ route('admin.department.search') }}",

            type: "GET",

            data: {
                search: search
            },

            success: function (response) {

                $('#departmentTableBody').html(response.html);

            },

            error: function (xhr) {

                console.log(xhr.responseText);

                $('#departmentTableBody').html(`
                    <tr>
                        <td colspan="6" class="text-center py-4 text-danger">
                            Something went wrong.
                        </td>
                    </tr>
                `);

            }

        });

    });

});

</script>

@endsection