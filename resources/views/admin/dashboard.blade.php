
@extends('layouts.app')

@include('layouts.auth')

@section('title', 'Admin Dashboard')

@section('content')

<main class="dashboard-content">
    <div class="container-fluid px-3 px-lg-4 py-4">

        <!-- Page Heading -->
        <div class="page-heading">
            <div class="page-heading-copy">

                <span class="page-icon">
                    <i class="bi bi-speedometer2"></i>
                </span>

                <div>
                    <p class="eyebrow mb-1">Employee Management</p>

                    <h1 class="h3 mb-1">Admin Dashboard</h1>

                    <p class="text-muted mb-0">
                        Manage employees and monitor your organization from one place.
                    </p>
                </div>

            </div>

            
        </div>


        <!-- Dashboard Metrics -->
        <section class="row g-3 mt-1">

            <!-- Total Employees -->
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-primary">

                    <div class="metric-top">
                        <span class="metric-label">
                            Total Employees
                        </span>

                        <span class="metric-icon">
                            <i class="bi bi-people-fill"></i>
                        </span>
                    </div>

                    <div class="metric-value">
                        {{ $totalEmployees }}
                    </div>

                    <div class="metric-meta">
                        <span>All employees</span>
                    </div>

                </article>
            </div>


            <!-- Active Employees -->
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-success">

                    <div class="metric-top">
                        <span class="metric-label">
                            Active Employees
                        </span>

                        <span class="metric-icon">
                            <i class="bi bi-person-check-fill"></i>
                        </span>
                    </div>

                    <div class="metric-value">
                        {{ $activeEmployees }}
                    </div>

                    <div class="metric-meta">
                        <span class="text-success">
                            Active
                        </span>

                        <span>employees</span>
                    </div>

                </article>
            </div>

            <!-- Inactive Employees -->
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-warning">

                    <div class="metric-top">
                        <span class="metric-label">
                            Inactive Employees
                        </span>

                        <span class="metric-icon">
                            <i class="bi bi-person-x-fill"></i>
                        </span>
                    </div>

                    <div class="metric-value">
                        {{ $inactiveEmployees }}
                    </div>

                    <div class="metric-meta">
                        <span class="text-danger">
                            Inactive
                        </span>

                        <span>employees</span>
                    </div>

                </article>
            </div>


            <!-- Departments -->
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-danger">

                    <div class="metric-top">
                        <span class="metric-label">
                            Departments
                        </span>

                        <span class="metric-icon">
                            <i class="bi bi-building"></i>
                        </span>
                    </div>

                    <div class="metric-value">
                        {{ $totalDepartments }}
                    </div>

                    <div class="metric-meta">
                        <span>Total departments</span>
                    </div>

                </article>
            </div>

        </section>


        <!-- Recent Employees -->
        <section class="card mt-4">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Recent Employees
                </h5>

                <a href="{{ route('admin.employee.list') }}"
                   class="btn btn-sm btn-outline-primary">
                    View All
                </a>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($recentEmployees as $employee)

                                <tr>

                                    <td>
                                        {{ $employee->name }}
                                    </td>

                                    <td>
                                        {{ $employee->email }}
                                    </td>

                                    <td>
                                        {{ $employee->department_name ?? 'N/A' }}
                                    </td>

                                    <td>

                                        @if($employee->status == 1)

                                            <span class="badge bg-success">
                                                Active
                                            </span>

                                        @else

                                            <span class="badge bg-danger">
                                                Inactive
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4"
                                        class="text-center py-4 text-muted">
                                        No employees found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </section>
    </div>
</main>

@endsection

