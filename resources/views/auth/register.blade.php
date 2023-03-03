@extends('layout.auth_master')
@section('title',"Register")
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
 <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="{{ asset('assets/img/logo.jpg') }}" alt="">
                  <span class="d-none d-lg-block">AlitaAdmin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                 	 <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>
                  	@if($errors->any())
                    	<div class="alert alert-danger">
                        <!-- <strong>Whoops!</strong> -->
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
             		@endif
             		<x-auth-session-status class="mb-4" :status="session('status')" />
                  	<form class="row g-3 needs-validation login_from" method="POST" action="{{ route('register') }}" id="register_form">
                       @csrf
                      <div class="col-6">
                        @php
                            $prefixes=['Mr.','Mrs','Miss','Dr','Er']
                        @endphp
                        <label for="prefix" class="form-label">Prefix<span class="text-danger"> * </span></label>
                          <select class="form-select form-control select2" id="prefix" name="prefix" placeholder="Select prefix" required>
                              <option selected disabled class="input-cstm">Please Select</option>
                              @foreach ($prefixes as $prefix)
                              <option @isset($employee->prefix) @if($employee->prefix==$prefix) selected @endif @endisset value="{{ $prefix }}">{{ $prefix }}</option>
                              @endforeach
                          </select>
                    </div>
                     <div class="col-6">
                      <label for="first_name" class="form-label">First Name<span class="text-danger"> * </span></label>
                        <input type="text" class="form-control" name="first_name" id="first_name"  autocomplete="off" placeholder="Enter First Name" required>
                    </div>

                    <div class="col-6">
                      <label for="middle_name" class="form-label">Middle Name<span class="text-danger"> * </span></label>
                        <input type="text" class="form-control" name="middle_name" id="middle_name" autocomplete="off" placeholder="Enter middle Name" required>
                    </div>

                    <div class="col-6">
                      <label for="last_name" class="form-label">Last Name<span class="text-danger"> * </span></label>
                         <input type="text" class="form-control" name="last_name" id="last_name"  autocomplete="off" placeholder="Enter Last Name" required>
                    </div>   
                    <div class="col-6">
                      <label for="email" class="form-label">Email<span class="text-danger"> * </span></label>
                      <div class="input-group  email-input">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" class="form-control email-input" name="email" id="email" placeholder="Enter User Email"  autocomplete="off" required>
                      </div>
                    </div>
                    <div class="col-6">
                      <label for="yourPassword" class="form-label">Password<span class="text-danger"> * </span></label>
                      <input type="password" name="password" class="form-control" id="password-input" placeholder="Enter password" autocomplete="current-password" required>
                    </div>

                    <div class="col-6">
                      <label for="yourPassword" class="form-label">Confirm Password</label>
                      <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Enter Confirm password" autocomplete="current-password" required>
                    </div>



                    <div class="col-12">
                    	<input type="submit" class="btn btn-primary w-100 waves-effect waves-light" value="Create Account">
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="{{ route('login')}}">Log in</a></p>
                    </div>
                     
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>
@endsection

@push('plugin-scripts')

  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
@endpush
@push('custom-scripts')
  <script src="{{ asset('assets/js/auth/register.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush