@extends('components.layout.auth')

@section('pageTitle')
Admin Login Page
@endSection

@section('authcontent')
<div class="login-box">
      <div class="login-logo">
        <a href="../index2.html"><b>Admin</b>LTE</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">

          <p class="login-box-msg">Change your password</p>

          <x-formmessage>
            
            <x-slot:errorslot :errors>

          </x-formmessage>


          @if(session('success'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
          @endif
          


          <form action=" {{ url('user/changepassword/') }} " method="post">
            @csrf
            
            <div class="input-group mb-3">
              <!-- <input type="email" class="form-control" name="email" placeholder="Email" /> -->
              <input type="password" name="current_password" class="form-control" placeholder="Current Password" />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>

            <div class="input-group mb-3">
              <!-- <input type="email" class="form-control" name="email" placeholder="Email" /> -->
              <input type="password" name="password" class="form-control" placeholder="New Password" />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password_confirmation" class="form-control" placeholder="New Re-Password" />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            <!--begin::Row-->
            <div class="row">
             
              <!-- /.col -->
              <div class="col-6">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-danger">Change Password</button>
                </div>
              </div>
              <div class="col-6">
                <div class="d-grid gap-2">
                  <a href="{{ url('/') }}" ><button type="button"  class="btn btn-primary">Cancel</button></a>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </form>
          
          
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->
     @endsection