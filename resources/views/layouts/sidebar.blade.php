<div class="sidebar-backdrop" data-sidebar-close></div>

<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">

    {{-- Logo / Brand --}}
    <div class="sidebar-header">
        <a class="brand-mark" href="{{ session('role') === 'admin' ? url('/admin/dashboard') : url('/employee/dashboard') }}">

            <span class="brand-icon">
                <i class="bi bi-grid-1x2-fill"></i>
            </span>
            <span class="brand-copy">
                <span class="brand-title">Employee</span>
                <span class="brand-subtitle">Management System</span>
            </span>
        </a>
    </div>


    {{-- Sidebar Navigation --}}
    <nav class="sidebar-nav">

        {{-- ================= ADMIN MENU ================= --}}
        @if(session('role') === 'admin')

            {{-- Dashboard --}}
            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
               href="{{ url('/admin/dashboard') }}">

                <span class="nav-icon">
                    <i class="bi bi-speedometer2"></i>
                </span>

                <span class="nav-text">
                    Dashboard
                </span>
            </a>


            {{-- Add Employee --}}
            <a class="nav-link"
               href="{{ route('admin.employee.create') }}">

                <span class="nav-icon">
                    <i class="bi bi-person-plus"></i>
                </span>

                <span class="nav-text">
                    Add Employee
                </span>

            </a>


            {{-- Employee List --}}
            <a class="nav-link"
               href="{{ route('admin.employee.list') }}">

                <span class="nav-icon">
                    <i class="bi bi-people"></i>
                </span>

                <span class="nav-text">
                    Employee List
                </span>

            </a>


            {{-- Department --}}
            <a class="nav-link"
               href="{{ route('admin.department.department') }}">

                <span class="nav-icon">
                    <i class="bi bi-diagram-3"></i>
                </span>

                <span class="nav-text">
                    Add Department
                </span>

            </a>


            {{-- Department List --}}
            <a class="nav-link"
               href="{{ route('admin.department.list') }}">

                <span class="nav-icon">
                    <i class="bi bi-list-ul"></i>
                </span>

                <span class="nav-text">
                    Department List
                </span>

            </a>


            {{-- Attendance --}}
            <a class="nav-link"
               href="{{ route('admin.attendance.create') }}">
                <span class="nav-icon">
                    <i class="bi bi-calendar-check"></i>
                </span>

                <span class="nav-text">
                    Add Attendance
                </span>
            </a>


            {{-- Attendance List --}}
            <a class="nav-link"
               href="{{ route('admin.attendance.list') }}">
                <span class="nav-icon">
                    <i class="bi bi-calendar-check"></i>
                </span>
                <span class="nav-text">
                    Attendance List
                </span>
            </a>


            {{-- Leave --}}
            <a class="nav-link"
               href="{{ route('admin.leave.create') }}">
                <span class="nav-icon">
                    <i class="bi bi-calendar2-minus"></i>
                </span>
                <span class="nav-text">
                    Add Leave
                </span>
            </a>


            {{-- Leave List --}}
            <a class="nav-link"
               href="{{ route('admin.leave.list') }}">

                <span class="nav-icon">
                    <i class="bi bi-list-ul"></i>
                </span>

                <span class="nav-text">
                    Leave List
                </span>
            </a>


            {{-- Profile --}}
            <a class="nav-link"
               href="{{ route('profile') }}">
                <span class="nav-icon">
                    <i class="bi bi-person-badge"></i>
                </span>
                <span class="nav-text">
                    Profile
                </span>
            </a>


        {{-- ================= EMPLOYEE MENU ================= --}}
        @elseif(session('role') === 'employee')
            {{-- Dashboard --}}
            <a class="nav-link {{ request()->is('employee/dashboard') ? 'active' : '' }}"
               href="{{ url('/employee/dashboard') }}">
                <span class="nav-icon">
                    <i class="bi bi-speedometer2"></i>
                </span>
                <span class="nav-text">
                    Dashboard
                </span>
            </a>


            {{-- My Profile --}}
            <a class="nav-link"
               href="{{ route('profile') }}">

                <span class="nav-icon">
                    <i class="bi bi-person-badge"></i>
                </span>
                <span class="nav-text">
                    My Profile
                </span>
            </a>


            {{-- My Attendance --}}
            <a class="nav-link"
               href="{{ route('employee.attendance') }}">

                <span class="nav-icon">
                    <i class="bi bi-calendar-check"></i>
                </span>

                <span class="nav-text">
                    My Attendance
                </span>

            </a>

            {{-- My Leave --}}
            <a class="nav-link"
               href="{{ route('employee.my_leave') }}">

                <span class="nav-icon">
                    <i class="bi bi-calendar2-minus"></i>
                </span>

                <span class="nav-text">
                    My Leave
                </span>
            </a>

            {{-- Apply Leave --}}
            <a class="nav-link"
               href="{{ route('employee.apply_leave') }}">

                <span class="nav-icon">
                    <i class="bi bi-calendar-plus"></i>
                </span>

                <span class="nav-text">
                    Apply Leave
                </span>

            </a>

        @else

            <div class="px-3 py-3 text-white">
                <small>Role not found</small>
            </div>

        @endif

    </nav>


    {{-- Sidebar Footer --}}
    <div class="sidebar-footer">

        <span class="status-dot"></span>

        <span class="sidebar-footer-text">
            System running smoothly
        </span>

    </div>

</aside>