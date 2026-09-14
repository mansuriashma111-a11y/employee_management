@extends('layouts.auth')

@section('title', 'Register')

@section('content')

<div class="container d-flex justify-content-center align-items-center min-vh-100">

     <div class="card shadow p-3" style="width: 380px;">

          <div class="text-center mb-3">

               <h3>Create Account</h3>

               <p class="text-muted mb-0">
                    Register for Employee Management System
               </p>

          </div>

          <form id="registerForm" enctype="multipart/form-data">

               @csrf

               <div class="mb-2">
                    <label class="form-label mb-1">Name</label>

                    <input type="text" name="name" class="form-control" placeholder="Enter your name">
                    <span class="text-danger error-name"></span>

               </div>
               <div class="mb-2">
                    <label class="form-label mb-1">Email</label>

                    <input type="email" name="email" class="form-control" placeholder="Enter your email">
                    <span class="text-danger error-email"></span>

               </div>
               <div class="mb-2">
                    <label class="form-label mb-1">Phone</label>

                    <input type="number" name="phone" class="form-control" placeholder="Enter Phone Number">
                    <span class="text-danger error-number"></span>

               </div>

               <div class="mb-2">
                    <label>Profile Image</label>
                    <input type="file" name="profile_image" class="form-control">
                    <span class="text-danger error-profile_image"></span>
               </div>

               <div class="mb-2">
                    <label class="form-label mb-1">Password</label>

                    <input type="password" name="password" class="form-control" placeholder="Enter password">
                    <span class="text-danger error-password"></span>

               </div>

               <div class="mb-3">
                    <label class="form-label mb-1">Confirm Password</label>

                    <input type="password" name="password_confirmation" class="form-control"
                         placeholder="Confirm password">
                    <span class="text-danger error-password_confirmation"></span>

               </div>

               <button type="submit" class="btn btn-primary w-100">
                    Register
               </button>

          </form>
          <div id="message"></div>

          <div class="text-center mt-2">
               <small>
                    Already have an account?
                    <a href="{{ url('/login') }}">Login</a>
               </small>
          </div>

     </div>

</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {

     $('#registerForm').submit(function(e) {

          e.preventDefault();

          // $('.text-danger').html('');

          let formData = new FormData(this);

          $.ajax({
               url: "{{route('register.store') }}",
               type: "post",
               data: formData,
               processData: false,
               contentType: false,
               success: function(response) {

                    showSuccessModal(response.message,'success');

                    $('#registerForm')[0].reset();

               },
               error:function(xhr){
                    
                    let response = xhr.responseJSON;

                    showSuccessModal(response.message,'error');
               }
          })

     });

});
</script>
@endsection