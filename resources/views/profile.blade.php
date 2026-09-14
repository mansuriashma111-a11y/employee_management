@extends('layouts.app')
@include('layouts.auth')
@section('title', 'My Profile')

@section('content')

<div class="container py-4">

     <div class="row justify-content-center">

          <div class="col-md-5 col-lg-7">

               <div class="card border-0 shadow-sm text-center">

                    {{-- Profile Header --}}
                    <div class="card-body p-4">

                         {{-- Profile Image --}}
                         @if($user->profile_image)

                         <img src="{{ asset('uploads/profile/' . $user->profile_image) }}" alt="Profile Image"
                              width="100" height="100" class="rounded-circle border border-3 border-primary mb-3">

                         @else

                         <img src="{{ asset('assets/images/avatar/avatar.jpg') }}" alt="Profile Image" width="100"
                              height="100" class="rounded-circle border border-3 border-primary mb-3">

                         @endif


                         {{-- Name --}}
                         <h5 class="fw-bold mb-1">
                              {{ $user->name }}
                         </h5>

                         {{-- Role --}}
                         <span class="badge bg-primary mb-3">
                              {{ ucfirst($user->role) }}
                         </span>
                         <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                              <i class="bi bi-pencil"></i>Edit
                         </a>

                         <hr>


                         {{-- User Details --}}
                         <div class="text-start">

                              <div class="d-flex justify-content-between mb-3">
                                   <span class="text-muted">
                                        <i class="bi bi-envelope"></i> Email
                                   </span>

                                   <span class="fw-semibold">
                                        {{ $user->email }}
                                   </span>
                              </div>


                              <div class="d-flex justify-content-between mb-3">
                                   <span class="text-muted">
                                        <i class="bi bi-telephone"></i> Phone
                                   </span>

                                   <span class="fw-semibold">
                                        {{ $user->phone ?? 'Not added' }}
                                   </span>
                              </div>


                              <div class="d-flex justify-content-between">
                                   <span class="text-muted">
                                        <i class="bi bi-person-badge"></i> Role
                                   </span>

                                   <span class="fw-semibold">
                                        {{ ucfirst($user->role) }}

                                   </span>


                              </div>

                         </div>

                    </div>

               </div>

          </div>

     </div>

</div>

@endsection