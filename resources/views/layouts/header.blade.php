<nav class="navbar admin-navbar navbar-expand bg-white border-bottom shadow-sm">
     <div class="container-fluid px-3 px-lg-4">
          <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar"
               aria-expanded="true" aria-label="Toggle sidebar">
               <span></span>
               <span></span>
               <span></span>
          </button>


          {{-- Right Side --}}
          <div class="ms-auto d-flex align-items-center gap-2">
               {{-- Theme Button --}}
               <button class="btn btn-light border rounded-circle p-2" type="button" data-theme-toggle
                    aria-label="Switch color theme" title="Switch color theme">
                    <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true">
                    </i>
               </button>


               {{-- User Profile --}}
               <div class="d-flex align-items-center border rounded-3 px-2 py-1 bg-body-subtle">
                    @if(session('profile_image'))
                    <img src="{{ asset('uploads/profile/' . session('profile_image')) }}" class="rounded-circle border"
                         width="40" height="40" alt="Profile">
                    @else
                    <img src="{{ asset('assets/images/avatar.jpg') }}" class="rounded-circle border" width="40"
                         height="40" alt="Profile">

                    @endif


                    <div class="ms-2 lh-sm">
                         <div class="fw-semibold">
                              {{ session('user_name', 'User') }}
                         </div>

                         <small class="text-muted">
                              {{ ucfirst(session('role', 'Role')) }}
                         </small>
                    </div>
               </div>


               {{-- Profile --}}
               <a href="{{ route('profile') }}" class="btn btn-outline-primary">

                    <i class="bi bi-person me-1"></i>
                    Profile
               </a>


               {{-- Logout --}}
               <a href="{{ route('logout') }}" class="btn btn-outline-danger">

                    <i class="bi bi-box-arrow-right me-1"></i>
                    Logout
               </a>

          </div>

     </div>
</nav>