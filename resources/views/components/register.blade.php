@extends('components.layout.auth')


@section('authcontent')
<div class="login-box">
      <div class="login-logo">
        <a href="../index2.html"><b>Admin</b>LTE</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">

          <p class="login-box-msg">Register a new membership</p>

          <x-formmessage>
            
            <x-slot:errorslot :errors>

          </x-formmessage>

          


          <form action=" {{ url('register') }} " method="post">
            @csrf
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Full Name">
              <div class="input-group-text"><span class="bi bi-person"></span></div>
            </div>

            <div class="input-group mb-3">
              <input type="email" class="form-control" name="email" placeholder="Email" />
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password" />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            <!--begin::Row-->
            <div class="row">
              <div class="col-8">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                  <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Sign In</button>
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