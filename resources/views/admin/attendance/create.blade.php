@extends('layouts.app')
@include('layouts.auth')

@section('title', 'Mark Attendance')

@section('content')

<div class="container-fluid px-3 px-lg-4 py-4">

     <div class="card border-0 shadow-sm">

          <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
               <h5 class="mb-0">
                    <i class="bi bi-calendar-check me-2"></i>
                    Mark Attendance
               </h5>
          </div>
          <div class="card-body">

               <div id="attendanceMessage"></div>

               <form id="attendanceForm">

                    @csrf

                    <div class="row g-3">

                         <!-- Employee -->
                         <div class="col-md-6">

                              <label class="form-label">
                                   Employee <span class="text-danger">*</span>
                              </label>

                              <select name="employee_id" id="employee_id" class="form-select">

                                   <option value="">Select Employee</option>

                                   @foreach($employees as $employee)

                                   <option value="{{ $employee->id }}">
                                        {{ $employee->user->name ?? 'Employee' }}
                                   </option>

                                   @endforeach

                              </select>

                              <small class="text-danger error-employee_id"></small>

                         </div>
                         <!-- Date -->
                         <div class="col-md-6">

                              <label class="form-label">
                                   Attendance Date
                                   <span class="text-danger">*</span>
                              </label>

                              <input type="date" name="attendance_date" id="attendance_date" class="form-control">

                              <small class="text-danger error-attendance_date"></small>

                         </div>


                         <!-- Check In -->
                         <div class="col-md-6">

                              <label class="form-label">
                                   Check In
                              </label>

                              <input type="time" name="check_in" class="form-control">

                         </div>


                         <!-- Check Out -->
                         <div class="col-md-6">

                              <label class="form-label">
                                   Check Out
                              </label>

                              <input type="time" name="check_out" class="form-control">

                         </div>


                         <!-- Status -->
                         <div class="col-md-6">

                              <label class="form-label">
                                   Status <span class="text-danger">*</span>
                              </label>

                              <select name="status" class="form-select">

                                   <option value="Present">Present</option>
                                   <option value="Absent">Absent</option>
                                   <option value="Half Day">Half Day</option>
                                   <option value="Leave">Leave</option>

                              </select>

                              <small class="text-danger error-status"></small>

                         </div>


                         <!-- Remarks -->
                         <div class="col-md-6">

                              <label class="form-label">
                                   Remarks
                              </label>

                              <input type="text" name="remarks" class="form-control" placeholder="Optional">

                         </div>


                         <!-- Submit -->
                         <div class="col-12">

                              <button type="submit" id="attendanceBtn" class="btn btn-primary">

                                   <i class="bi bi-check-circle me-1"></i>
                                   Mark Attendance

                              </button>

                         </div>

                    </div>

               </form>

          </div>
     </div>

</div>

@endsection
@push('scripts')

<script>
$(document).ready(function() {
     $('#attendanceForm').submit(function(e) {
          e.preventDefault();

          let form = this;
          let button = $('#attendanceBtn');

          $('.text-danger').text('');
          $('#attendanceMessage').html('');

          $.ajax({

               url: "{{ route('admin.attendance.store') }}",

               type: "POST",

               data: $(form).serialize(),

               success: function(response) {

                    if (response.status) {

                         showSuccessModal(response.message, 'success');

                         form.reset();
                    }

               },
               error: function(xhr) {

                    let response = xhr.responseJSON;

                    showSuccessModal(response.message, 'error');
               },



          });

     });

});
</script>

@endpush