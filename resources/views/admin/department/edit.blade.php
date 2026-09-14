@extends('layouts.app')
@include('layouts.auth')

@section('title', 'Edit Department')

@section('content')

<main class="dashboard-content">

    <div class="container-fluid px-3 px-lg-4 py-4">

        <div class="page-heading mb-4">
            <div>
                <h2>Edit Department</h2>
                <p class="text-muted mb-0">Update department details</p>
            </div>
        </div>


        <div class="card shadow-sm border-0">

            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="bi bi-building me-2"></i>
                    Department Details
                </h5>
            </div>


            <div class="card-body">

                <form
                    action="{{ route('admin.department.update', $department->id) }}"
                    method="POST"
                    id="editDepartmentForm">

                    @csrf
                    @method('PUT')

                    <!-- Department Name -->
                    <div class="mb-3">

                        <label class="form-label">
                            Department Name
                        </label>

                        <input
                            type="text"
                            name="department_name"
                            class="form-control"
                            value="{{ old('department_name', $department->department_name) }}"
                            placeholder="Enter department name"
                            required>

                    </div>


                    <!-- Description -->
                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="4"
                            placeholder="Enter description">{{ old('description', $department->description) }}</textarea>

                    </div>


                    <!-- Status -->
                    <div class="mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status" class="form-select" required>

                            <option
                                value="1"
                                {{ old('status', $department->status) == 1 ? 'selected' : '' }}>
                                Active
                            </option>

                            <option
                                value="0"
                                {{ old('status', $department->status) == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>


                    <!-- Buttons -->
                    <div class="d-flex gap-2 mt-4">

                        <button
                            type="submit"
                            class="btn btn-primary"
                            id="updateDepartmentBtn">

                            <i class="bi bi-check-circle me-1"></i>
                            Update Department

                        </button>


                        <a
                            href="{{ route('admin.department.list') }}"
                            class="btn btn-secondary">

                            <i class="bi bi-arrow-left me-1"></i>
                            Back

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</main>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<!-- AJAX Update -->
<script>

$(document).ready(function () {

    $('#editDepartmentForm').on('submit', function (e) {

        e.preventDefault();

        let form = this;
        let button = $('#updateDepartmentBtn');

        button.prop('disabled', true);

        button.html(
            '<span class="spinner-border spinner-border-sm me-1"></span> Updating...'
        );


        $.ajax({

            url: $(form).attr('action'),

            type: 'POST',

            data: $(form).serialize(),

            success: function (response) {

                showSuccessModal(
                    response.message || 'Department updated successfully.',
                    'success'
                );

                button.prop('disabled', false);

                button.html(
                    '<i class="bi bi-check-circle me-1"></i> Update Department'
                );

                // Success ke baad list par
                setTimeout(function () {

                    window.location.href =
                        "{{ route('admin.department.list') }}";

                }, 1200);

            },


            error: function (xhr) {

                let message = 'Something went wrong.';

                if (xhr.status === 422 && xhr.responseJSON) {

                    if (xhr.responseJSON.errors) {

                        let errors = xhr.responseJSON.errors;

                        message = Object.values(errors)
                            .flat()
                            .join('\n');

                    } else if (xhr.responseJSON.message) {

                        message = xhr.responseJSON.message;

                    }

                } else if (
                    xhr.responseJSON &&
                    xhr.responseJSON.message
                ) {

                    message = xhr.responseJSON.message;

                }


                showSuccessModal(message, 'error');


                button.prop('disabled', false);

                button.html(
                    '<i class="bi bi-check-circle me-1"></i> Update Department'
                );

            }

        });

    });

});

</script>

@endsection