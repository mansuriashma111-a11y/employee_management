@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<div class="container d-flex justify-content-center align-items-center min-vh-100">

     <div class="card shadow p-4" style="width: 400px;">

          <div class="text-center mb-4">
               <h2>Employee Management System</h2>
               <p class="text-muted">Login to your account</p>
          </div>

          <form id="loginForm">

               @csrf

               <div class="mb-3">
                    <label class="form-label">Email</label>

                    <input type="email" name="email" class="form-control" placeholder="Enter your email">

                    <span class="text-danger error-email"></span>
               </div>

               <div class="mb-3">
                    <label class="form-label">Password</label>

                    <input type="password" name="password" class="form-control" placeholder="Enter your password">

                    <span class="text-danger error-password"></span>
               </div>

               <button type="submit" class="btn btn-primary w-100">
                    Login
               </button>

          </form>
          <div id="message"></div>


          <div class="text-center mt-3">
               <span>Don't have an account?</span>
               <a href="{{ url('/register') }}">Register</a>
          </div>

     </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function() {

     //  console.log('JS Loaded');

     $('#loginForm').on('submit', function(e) {

          e.preventDefault();

          //   alert('AJAX working');

          $.ajax({

               url: "{{ route('login.store') }}",

               type: "POST",

               data: $(this).serialize(),

               success: function(response) {

                    // alert(response.message);
                    showSuccessModal(response.message,'success');


                    $('#loginForm')[0].reset();

                    window.location.href = response.redirect;
               },
              
               error: function(xhr) {

                    let response = xhr.responseJSON;

                    showSuccessModal(response.message, 'error');
               },
               


          });

     });

});
</script>

@endsection