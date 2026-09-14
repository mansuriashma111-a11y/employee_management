@extends('layouts.app')

@include('layouts.auth')

@section('title', 'Add Department')

@section('content')

<div class="row justify-content-center">

    <div class="col-12 col-xl-10">

        <div class="card border-0 shadow-sm">

            <!-- Header -->
            <div class="card-header bg-dark text-white">

                <h5 class="mb-0">
                    Department Details
                </h5>

            </div>


            <!-- Body -->
            <div class="card-body p-4">

                <form 
                    
                      id="departmentForm">

                    @csrf

                    <div class="row">


                        <!-- Department Name -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Department Name
                            </label>

                            <input type="text"
                                   name="department_name"
                                   class="form-control"
                                   placeholder="Enter department name"
                                   value="{{ old('department_name') }}">

                            @error('department_name')

                                <span class="text-danger">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>


                        <!-- Status -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="status"
                                    class="form-control">

                                <option value="1"
                                    {{ old('status', 1) == 1 ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0"
                                    {{ old('status') == '0' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>

                            @error('status')

                                <span class="text-danger">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>


                        <!-- Description -->
                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea name="description"
                                      rows="4"
                                      class="form-control"
                                      placeholder="Enter department description">{{ old('description') }}</textarea>

                            @error('description')

                                <span class="text-danger">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>


                    <!-- Buttons -->
                    <div class="mt-3">

                        <button type="submit"
                                class="btn btn-primary"
                                id="departmentBtn">

                            <i class="bi bi-plus-circle"></i>

                            Add Department

                        </button>


                        <a href="{{ route('admin.department.list') }}"
                           class="btn btn-secondary">

                            Cancel

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



<!-- ===================================================== -->
<!-- AJAX -->
<!-- ===================================================== -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<script>

$(document).ready(function () {


    $('#departmentForm').on('submit', function (e) {

        e.preventDefault();


        let form = this;

        let button = $('#departmentBtn');


        // Disable button
        button.prop('disabled', true);

        button.html(
            '<span class="spinner-border spinner-border-sm me-1"></span> Saving...'
        );


        $.ajax({

            url: "{{ route('admin.department.store') }}",

            type: "POST",

            data: $(form).serialize(),


            success: function (response) {


                // Show success modal
                showSuccessModal(
                    response.message || 'Department added successfully.',
                    'success'
                );


                // Reset form
                form.reset();


                // Button normal
                button.prop('disabled', false);

                button.html(
                    '<i class="bi bi-plus-circle"></i> Add Department'
                );

            },


            error: function (xhr) {


                let message = 'Something went wrong.';


                // Validation errors
                if (xhr.status === 422 && xhr.responseJSON) {

                    if (xhr.responseJSON.errors) {

                        let errors = xhr.responseJSON.errors;

                        message = Object.values(errors)
                            .flat()
                            .join('\n');

                    }

                    else if (xhr.responseJSON.message) {

                        message = xhr.responseJSON.message;

                    }

                }

                else if (xhr.responseJSON && xhr.responseJSON.message) {

                    message = xhr.responseJSON.message;

                }


                // Show error modal
                showSuccessModal(
                    message,
                    'error'
                );


                // Enable button
                button.prop('disabled', false);

                button.html(
                    '<i class="bi bi-plus-circle"></i> Add Department'
                );

            }

        });

    });

});

</script>


@endsection