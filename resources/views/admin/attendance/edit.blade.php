@extends('layouts.app')

@include('layouts.auth')

@section('content')

<div class="container-fluid">

     <div class="card shadow-sm">

          <div class="card-header">
               <h4 class="mb-0">Edit Attendance</h4>
          </div>

          <div class="card-body">

               <form id="editAttendanceForm">

                    @csrf

                    <input type="hidden" id="attendance_id" value="{{ $attendance->id }}">


                    <!-- Attendance Date -->
                    <div class="mb-3">

                         <label class="form-label">
                              Attendance Date
                         </label>

                         <input type="date" id="attendance_date" class="form-control"
                              value="{{ $attendance->attendance_date }}" required>

                    </div>


                    <!-- Check In -->
                    <div class="mb-3">

                         <label class="form-label">
                              Check In
                         </label>

                         <input type="time" id="check_in" class="form-control" value="{{ $attendance->check_in }}">

                    </div>

                    <!-- Check Out -->
                    <div class="mb-3">

                         <label class="form-label">
                              Check Out
                         </label>

                         <input type="time" id="check_out" class="form-control" value="{{ $attendance->check_out }}">

                    </div>


                    <!-- Status -->
                    <div class="mb-3">

                         <label class="form-label">
                              Status
                         </label>

                         <select id="status" class="form-control" required>

                              <option value="Present" {{ $attendance->status == 'Present' ? 'selected' : '' }}>
                                   Present
                              </option>

                              <option value="Absent" {{ $attendance->status == 'Absent' ? 'selected' : '' }}>
                                   Absent
                              </option>

                              <option value="Half Day" {{ $attendance->status == 'Half Day' ? 'selected' : '' }}>
                                   Half Day
                              </option>

                              <option value="Leave" {{ $attendance->status == 'Leave' ? 'selected' : '' }}>
                                   Leave
                              </option>

                         </select>

                    </div>


                    <!-- Remarks -->
                    <div class="mb-3">

                         <label class="form-label">
                              Remarks
                         </label>

                         <textarea id="remarks" class="form-control" rows="3">{{ $attendance->remarks }}</textarea>

                    </div>


                    <!-- Buttons -->

                    <button type="submit" class="btn btn-primary">

                         Update Attendance

                    </button>


                    <a href="{{ route('admin.attendance.list') }}" class="btn btn-secondary">

                         Cancel

                    </a>

               </form>

          </div>

     </div>

</div>

@endsection


@push('scripts')
<script>

$(document).ready(function() {

     $('#editAttendanceForm').on('submit', function(e) {

          e.preventDefault();

          let attendanceId = $('#attendance_id').val();

          $.ajax({

               url: '/admin/attendance/update/' + attendanceId,

               type: 'PUT',

               data: {

                    _token: '{{ csrf_token() }}',

                    attendance_date: $('#attendance_date').val(),

                    check_in: $('#check_in').val(),

                    check_out: $('#check_out').val(),

                    status: $('#status').val(),

                    remarks: $('#remarks').val()

               },


               success: function(response) {
                    console.log(response);
                    if (response.status === true) {

                         // alert(response.message);
                         showSuccessModal(response.message, 'success');

                         window.location.href =
                              '/admin/attendance';

                    }

               },


               error: function(xhr) {

                    console.log(xhr.responseText);

                    if (xhr.status === 422) {

                         let response =
                              xhr.responseJSON;

                         // alert(response.message);
                         showSuccessModal(response.message, 'error');


                    } else {

                         alert(
                              'Something went wrong while updating attendance.'
                         );

                    }

               }

          });

     });

});
</script>
@endpush