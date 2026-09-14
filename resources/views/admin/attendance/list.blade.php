@extends('layouts.app')

@include('layouts.auth')

@section('title', 'Attendance List')

@section('content')

<div class="container-fluid px-3 px-lg-4 py-4">

     <div class="card border-0 shadow-sm">

          <!-- Header -->
          <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

               <h5 class="mb-0">
                    <i class="bi bi-calendar-check me-2"></i>
                    Attendance Table
               </h5>

               <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Mark Attendance
               </a>

          </div>

          <div class="card-body">

               <!-- Page Heading + Search -->
               <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                         <h5 class="mb-1">Attendance Table</h5>

                         <p class="text-muted mb-0">
                              Manage employee attendance data.
                         </p>
                    </div>

                    <input type="text" id="searchAttendance" class="form-control" placeholder="Search attendance"
                         style="width: 250px;">

               </div>

               <!-- Table -->
               <div class="table-responsive">

                    <table class="table table-hover align-middle" id="attendanceTable">

                         <thead>

                              <tr>
                                   <th>#</th>
                                   <th>EMPLOYEE</th>
                                   <th>DATE</th>
                                   <th>CHECK IN</th>
                                   <th>CHECK OUT</th>
                                   <th>STATUS</th>
                                   <th>REMARKS</th>
                                   <th>Action</th>
                              </tr>

                         </thead>

                         <tbody>

                              @forelse($attendances as $attendance)

                              <tr id="attendanceRow{{ $attendance->id }}">

                                   <!-- Number -->
                                   <td>
                                        {{ $attendances->firstItem() + $loop->index }}
                                   </td>

                                   <!-- Employee -->
                                   <td>
                                        {{ $attendance->employee->user->name ?? 'Employee' }}
                                   </td>

                                   <!-- Date -->
                                   <td>
                                        {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d-m-Y') }}
                                   </td>

                                   <!-- Check In -->
                                   <td>
                                        {{ $attendance->check_in ?? '-' }}
                                   </td>

                                   <!-- Check Out -->
                                   <td>
                                        {{ $attendance->check_out ?? '-' }}
                                   </td>

                                   <!-- Status -->
                                   <td>

                                        @if($attendance->status == 'Present')

                                        <span class="badge bg-success">
                                             Present
                                        </span>

                                        @elseif($attendance->status == 'Absent')

                                        <span class="badge bg-danger">
                                             Absent
                                        </span>

                                        @elseif($attendance->status == 'Half Day')

                                        <span class="badge bg-warning text-dark">
                                             Half Day
                                        </span>

                                        @else

                                        <span class="badge bg-info">
                                             Leave
                                        </span>

                                        @endif

                                   </td>

                                   <!-- Remarks -->
                                   <td>
                                        {{ $attendance->remarks ?? '-' }}
                                   </td>

                                   <!-- Action -->
                                   <td class="text-end">
                                        <!-- Delete -->
                                        <form action="{{route('admin.attendance.delete',$attendance->id)}}"
                                             method="POST" class="d-inline">

                                             @csrf
                                             @method('DELETE')

                                             <button type="button" class="btn btn-sm btn-danger deleteBtn"
                                                  data-message="Are you sure you want to delete this department?">

                                                  <i class="bi bi-trash"></i>

                                             </button>

                                        </form>

                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.attendance.edit', $attendance->id) }}"
                                             class="btn btn-primary btn-sm">

                                             <i class="bi bi-pencil"></i>

                                        </a>

                                   </td>

                              </tr>

                              @empty

                              <tr>
                                   <td colspan="8" class="text-center">
                                        No attendance found.
                                   </td>
                              </tr>

                              @endforelse

                         </tbody>

                    </table>

               </div>

               <!-- Pagination -->
               <div class="mt-3">
                    {{ $attendances->links() }}
               </div>

          </div>

     </div>

</div>

@endsection


@push('scripts')

<script>
$(document).ready(function() {

     // =========================
     // Search Attendance
     // =========================

     $('#searchAttendance').on('keyup', function() {

          let value = $(this).val().toLowerCase();

          $('#attendanceTable tbody tr').filter(function() {

               $(this).toggle(
                    $(this).text().toLowerCase().indexOf(value) > -1
               );

          });

     });

});





</script>

@endpush