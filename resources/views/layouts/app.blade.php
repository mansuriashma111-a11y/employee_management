<!DOCTYPE html>
<html lang="en">

<head>
     <title>@yield('title', 'Employee Management System')</title>

     <meta charset="UTF-8">

     <meta name="csrf-token" content="{{ csrf_token() }}">

     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <meta name="description" content="Employee Management System">

     {{-- Bootstrap CSS --}}
     <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

     {{-- Bootstrap Icons --}}
     <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">

     {{-- Custom CSS --}}
     <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const sidebarButton = document.querySelector('[data-sidebar-toggle]');
    const sidebar = document.querySelector('#adminSidebar');

    if (!sidebarButton || !sidebar) {
        console.log('Sidebar button ya sidebar nahi mila');
        return;
    }

    sidebarButton.addEventListener('click', function (e) {
        e.preventDefault();

        if (window.innerWidth >= 992) {

            document.body.classList.toggle('sidebar-mini');

            const isMini = document.body.classList.contains('sidebar-mini');

            sidebarButton.setAttribute(
                'aria-expanded',
                String(!isMini)
            );

            console.log('Sidebar:', isMini ? '83px' : '280px');

        } else {

            document.body.classList.toggle('sidebar-open');

            const isOpen = document.body.classList.contains('sidebar-open');

            sidebarButton.setAttribute(
                'aria-expanded',
                String(isOpen)
            );

        }
    });

});
</script>
<body>

     <div class="admin-shell">

          {{-- Sidebar --}}
          @include('layouts.sidebar')

          <div class="admin-main">

               {{-- Header --}}
               @include('layouts.header')

               {{-- Main Content --}}
               <main class="dashboard-content">

                    <div class="container-fluid px-3 px-lg-4 py-4">

                         @yield('content')

                    </div>

               </main>

               {{-- Footer --}}
               @include('layouts.footer')

          </div>
     </div>

     {{-- jQuery --}}
     <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


     {{-- Bootstrap JS --}}
     <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>


     {{-- Main JS --}}
     <script src="{{ asset('assets/js/main.js') }}"></script>


     {{-- Page Specific Scripts --}}
     @stack('scripts')


</body>

</html>