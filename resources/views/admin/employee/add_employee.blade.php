@extends('layouts.app')
@include('layouts.auth')

@section('title', 'Add Employee')

@section('content')

<section class="row g-3">

     <div class="col-12">
          <form action="{{ route('employee.store') }}" method="POST" id="employeeForm"
               class="panel needs-validation w-100" novalidate>
               @csrf
               <!-- Header -->
               <div class="panel-header">
                    <div>
                         <h2 class="h5 mb-1 section-title">
                              <i class="bi bi-person-vcard"></i>
                              <span>Employee Information</span>
                         </h2>

                         <p class="text-muted mb-0">
                              Enter employee details below.
                         </p>
                    </div>

               </div>


               <!-- Form Fields -->
               <div class="row g-3 mt-1">

                    <!-- User -->
                    <div class="col-lg-6">

                         <label class="form-label">
                              Employee
                         </label>

                         <select class="form-select" name="user_id" required>

                              <option value="">
                                   Select Employee
                              </option>

                              @foreach($users as $user)

                              <option value="{{ $user->id }}">
                                   {{ $user->name }} - {{ $user->email }}
                              </option>

                              @endforeach

                         </select>

                         <div class="invalid-feedback">
                              Please select employee.
                         </div>

                    </div>
                    <div class="col-lg-6">
                         <div class="mb-3">
                              <label class="form-label">Department</label>

                              <select name="department_id" class="form-select" required>

                                   <option value="">Select Department</option>

                                   @foreach($departments as $department)

                                   <option value="{{ $department->id }}">
                                        {{ $department->department_name }}
                                   </option>

                                   @endforeach

                              </select>

                              <div class="invalid-feedback">
                                   Please select department
                              </div>

                         </div>
                    </div>
                    <!-- Designation -->
                    <div class="col-lg-6">

                         <label class="form-label">
                              Designation
                         </label>

                         <input type="text" class="form-control" name="designation" placeholder="Enter designation"
                              required>

                         <div class="invalid-feedback">
                              Designation is required.
                         </div>

                    </div>

                    <!-- Salary -->
                    <div class="col-lg-6">

                         <label class="form-label">
                              Salary
                         </label>

                         <input type="number" class="form-control" name="salary" placeholder="Enter salary" min="1"
                              step="0.01" required>

                         <div class="invalid-feedback">
                              Enter a valid salary.
                         </div>

                    </div>

               </div>


               <!-- Buttons -->
               <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ url('/admin/employee') }}" class="btn btn-secondary">

                         <i class="bi bi-arrow-left"></i>
                         Back

                    </a>

                    <button class="btn btn-primary" type="submit">

                         <i class="bi bi-person-plus"></i>
                         Add Employee

                    </button>

               </div>

          </form>
          <div class="message"></div>
     </div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

@push('scripts')
<script>
$(document).ready(function() {

     $('#employeeForm').submit(function(e) {

          e.preventDefault();

          let form = this;

          // Pehle validation check karo
          if (!form.checkValidity()) {

               // Required/invalid fields show karo
               $(form).addClass('was-validated');

               return;
          }

          let formData = new FormData(form);

          $.ajax({

               url: $(form).attr('action'),

               type: 'POST',

               data: formData,

               processData: false,

               contentType: false,

               success: function(response) {

                    if (response.status) {

                         // Form reset
                         form.reset();

                         // Validation state completely clear
                         $(form).removeClass('was-validated');

                         $(form).find('.is-invalid').removeClass('is-invalid');
                         $(form).find('.is-valid').removeClass('is-valid');

                         // Success modal
                         showSuccessModal(response.message, 'success');
                    }
               },

               error: function(xhr) {

                    let response = xhr.responseJSON;

                    showSuccessModal(
                         response.message || 'Something went wrong.',
                         'error'
                    );
               }

          });

     });

});
</script>
@endpush
@endsection