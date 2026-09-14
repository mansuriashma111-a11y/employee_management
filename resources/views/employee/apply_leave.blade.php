@extends('layouts.app')

@section('title', 'Apply Leave')

@section('content')

<div class="container-fluid px-3 px-lg-4 py-4">

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <h4 class="mb-4">Apply Leave</h4>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('employee.store_leave') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label class="form-label">Leave Type</label>

                    <select name="leave_type" class="form-select">
                        <option value="">Select Leave Type</option>
                        <option value="Casual Leave">Casual Leave</option>
                        <option value="Sick Leave">Sick Leave</option>
                        <option value="Paid Leave">Paid Leave</option>
                        <option value="Emergency Leave">Emergency Leave</option>
                    </select>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">From Date</label>

                        <input type="date"
                               name="from_date"
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">To Date</label>

                        <input type="date"
                               name="to_date"
                               class="form-control">
                    </div>

                </div>

                <div class="mb-3">
                    <label class="form-label">Reason</label>

                    <textarea name="reason"
                              class="form-control"
                              rows="4"
                              placeholder="Enter leave reason"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Apply Leave
                </button>

            </form>

        </div>

    </div>

</div>

@endsection