@extends('layouts.app')
@include('layouts.auth')

@section('title', 'Edit Profile')

@section('content')

<div class="container py-4">

     <div class="row justify-content-center">

          <div class="col-md-6">

               <div class="card shadow-sm border-0">

                    <div class="card-header">
                         <h5 class="mb-0">Edit Profile</h5>
                    </div>

                    <div class="card-body">

                         <div id="message"></div>

      <form id="profileForm" enctype="multipart/form-data">

                              @csrf

                              <div class="text-center mb-3">

                                   @if($user->profile_image)

                                   <img src="{{ asset('uploads/profile/' . $user->profile_image) }}" width="100"
                                        height="100" class="rounded-circle">

                                   @else

                                   <img src="{{ asset('assets/images/default-user.png') }}" width="100" height="100"
                                        class="rounded-circle">

                                   @endif

                              </div>


                              <div class="mb-3">

                                   <label class="form-label">Name</label>

                                   <input type="text" name="name" class="form-control" value="{{ $user->name }}">

                              </div>


                              <div class="mb-3">

                                   <label class="form-label">Email</label>

                                   <input type="email" name="email" class="form-control" value="{{ $user->email }}">

                              </div>


                              <div class="mb-3">

                                   <label class="form-label">Phone</label>

                                   <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">

                              </div>


                              <div class="mb-3">

                                   <label class="form-label">Profile Image</label>

                                   <input type="file" name="profile_image" class="form-control">

                              </div>


                              <button type="submit" class="btn btn-primary">
                                   Update Profile
                              </button>

                         </form>
                         <div id="message"></div>


                    </div>

               </div>

          </div>

     </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function() {

     $('#profileForm').submit(function(e) {

          e.preventDefault();

          let formData = new FormData(this);
          $.ajax({

               url: "{{ route('profile.update') }}",

               type: "POST",

               data: formData,

               processData: false,

               contentType: false,

               success: function(response) {

                    showSuccessModal(response.message);

                    $('#profileForm')[0].reset();
                    
                    window.location.href = "{{ route('profile') }}";

               },




          });

     });

});
</script>


@endsection