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

          <p class="login-box-msg">Reset your Password</p>

          <x-formmessage>
            
            <x-slot:errorslot :errors>

          </x-formmessage>

          


          <form action=" {{ url('resetpasswordupdate') }} " method="post">
            @csrf

            

            <div class="input-group mb-3">              
              
              <input type="hidden" value="{{ $data->token  }}" name="token" class="form-control"  />
              <input type="hidden" value="{{ $data->email  }}" name="email" class="form-control"  />

              <input type="password" name="password" class="form-control" placeholder="New Password" />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            
            <div class="input-group mb-3">
              <input type="password" name="password_confirmation" class="form-control" placeholder="Re-New Password" />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            
            <!--begin::Row-->
            <div class="row">
              
              <!-- /.col -->
              <div>
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
              </div>
              <!-- /.col -->
            </div>
            
            <!--end::Row-->
          </form>
          <!-- <div class="social-auth-links text-center mb-3 d-grid gap-2">
            <p>- OR -</p>
            <a href="#" class="btn btn-primary">
              <i class="bi bi-facebook me-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-danger">
              <i class="bi bi-google me-2"></i> Sign in using Google+
            </a>
          </div> -->
          <!-- /.social-auth-links -->
          
          
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->
     @endsection