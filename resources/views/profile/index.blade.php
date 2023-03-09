@extends('layout.master')
@section('title',"Profile")
@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="pagetitle">
  <h1>Profile</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Users</li>
      <li class="breadcrumb-item active">Profile</li>
    </ol>
  </nav>
</div>
<section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
               @if(empty(Auth::user()->image))
              <img src="assets/img/admin_logo.png" alt="Profile" class="rounded-circle">
              @else
              <img src="{{ asset('images/users/profile/'. Auth::user()->image) }}" alt="Profile" class="rounded-circle">
            @endif
              <h2>{{ ucwords(Auth::user()->prefix).'.'.Auth::user()->first_name.' '. Auth::user()->last_name }}</h2>
              <h3>{{ (!empty($data['user']->designation)) ? $data['user']->designation->name : ''}}</h3>
              <!-- <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div> -->
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

               

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @endif
              @if (session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
               {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @endif
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  @if(!empty(Auth::user()->about))
                  <h5 class="card-title">About</h5>
                  <p class="small fst-italic">{{ Auth::user()->about }}</p>
                  @endif
                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8">{{ ucwords(Auth::user()->prefix).'.'.Auth::user()->first_name.' '. Auth::user()->middle_name.' '. Auth::user()->last_name }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Job</div>
                    <div class="col-lg-9 col-md-8">{{ (!empty($data['user']->designation)) ? $data['user']->designation->name : ''}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8">{{ (empty(Auth::user()->address))? '-' : Auth::user()->address  }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8">{{ (empty(Auth::user()->phone)) ? '-' : Auth::user()->phone}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{Auth::user()->email}}</div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="{{ route('profile.update',Auth::user()->id) }}" method="POST" id="edit_profile_form" enctype="multipart/form-data">
                     @csrf
                     @method('PUT')
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                         @php
                            $image='';
                            if(!empty(Auth::user()->image))
                            {
                              $image='images/users/profile/'. Auth::user()->image;
                            }
                            else
                            {
                              $image='assets/img/admin_logo.png';
                            }
                        @endphp
                        <img src="{{ asset($image) }}" class="profile_image" alt="Profile">
                       
                        <div class="pt-2">
                          <input type="file" name="image" onchange="loadFile(event)" id="imgupload" style="display:none"/> 
                          <a class="btn btn-primary btn-sm" id="OpenImgUpload" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <a class="btn btn-danger btn-sm remove_profile_img" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                          <input type="hidden" name="remove_img" class="remove_img" value="0">
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Prefix<span class="text-danger"> * </span></label>
                      <div class="col-md-8 col-lg-9">
                         @php
                            $prefixes=['Mr','Mrs','Miss','Dr','Er']
                        @endphp
                          <select class="form-select form-control select2" id="prefix" name="prefix" placeholder="Select prefix" required>
                              <option selected disabled class="input-cstm">Please Select</option>
                              @foreach ($prefixes as $prefix)
                              <option @if(Auth::user()->prefix==$prefix) selected @endif value="{{ $prefix }}">{{ $prefix }}</option>
                              @endforeach
                          </select>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">First Name<span class="text-danger"> * </span></label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" name="first_name" id="first_name"  autocomplete="off" placeholder="Enter First Name" value="{{ Auth::user()->first_name }}" required>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Middle Name<span class="text-danger"> * </span></label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" name="middle_name" id="middle_name" autocomplete="off" placeholder="Enter middle Name" value="{{ Auth::user()->middle_name }}" required>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Last Name<span class="text-danger"> * </span></label>
                      <div class="col-md-8 col-lg-9">
                          <input type="text" class="form-control" name="last_name" id="last_name"  autocomplete="off" placeholder="Enter Last Name" value="{{ Auth::user()->last_name }}" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea name="about" class="form-control" id="about" style="height: 100px">{{ Auth::user()->about }}</textarea>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">DOB</label>
                      <div class="col-md-8 col-lg-9">
                        <div class="input-group ">
                         <input type="text" name="dob" value="{{ Auth::user()->dob }}" class="form-control dobdatePicker" autocomplete="off" id="dobdatePicker">
                        <span class="input-group-text input-group-addon"><div class="icon">
                           <i class="bi bi-calendar4"></i>
                           </div></span>
                      </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                        @php
                        $genders = [['key' => 0 , 'value' => 'MALE'],['key' => 1 , 'value' => 'FEMALE']]
                    @endphp
                      <label for="department_id" class="col-md-4 col-lg-3 col-form-label">Gender</label>
                      <div class="col-md-8 col-lg-9">
                        <select class="form-select form-control select2" id="gender" name="gender" placeholder="Select Gender">
                            <option selected disabled class="input-cstm">Please Select</option>
                            @foreach ($genders as $gender)
                                <option @if(!empty(Auth::user()->gender) && Auth::user()->gender == $gender['key']) selected @endif value="{{ $gender['key'] }}">{{ $gender['value'] }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="department_id" class="col-md-4 col-lg-3 col-form-label">Department</label>
                      <div class="col-md-8 col-lg-9">
                        <select class="form-select form-control select2" id="department_id" name="department_id" placeholder="Select Department" >
                              <option selected disabled class="input-cstm">Please Select</option>
                              @if(!empty($data['department']))
                              @foreach ($data['department'] as $department)
                              <option @if(Auth::user()->department_id ==$department->id) selected @endif  value="{{ $department->id }}">{{ $department->name }}</option>
                              @endforeach
                              @endif
                          </select>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="designation_id" class="col-md-4 col-lg-3 col-form-label">Department</label>
                      <input type="hidden" name="exit_designation_id" id="exit_designation_id" value="{{Auth::user()->designation_id}}">
                      <div class="col-md-8 col-lg-9">
                        <select class="form-select form-control select2" id="designation_id" name="designation_id" placeholder="Select First Department" >
                              <option selected disabled class="input-cstm">Please First select Department</option>
                          </select>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                      <div class="col-md-8 col-lg-9">
                        
                        <textarea name="address" class="form-control" id="address" style="height: 100px">{{ Auth::user()->address }}</textarea>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control" id="Phone" value="{{ Auth::user()->phone }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email<span class="text-danger"> * </span></label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="Email" value="{{Auth::user()->email}}" disabled>
                      </div>
                    </div>

                   

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

               

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  
                  <form method="POST" action="{{ route('change-password.store')}}" id="change_password_form">
                    @csrf
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="currentPassword" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password_confirmation" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>
  @endsection

  @push('plugin-scripts')
 <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
 <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
@endpush
@push('custom-scripts')
 <script src="{{ asset('assets/js/profile/profile.js') }}"></script>
  <script src="{{ asset('assets/js/profile/change-password.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
@endpush