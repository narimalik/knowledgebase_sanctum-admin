@extends('components.layout.auth')

@section('pageTitle')
 Forgot Password
@endSection

@section('authcontent')
<div class="login-box">
      <div class="login-logo">
        <a href="../index2.html"><b>Admin</b>LTE</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">

          <p class="login-box-msg">Forgot Password</p>

          <x-formmessage>
            
            <x-slot:errorslot :errors>

          </x-formmessage>




         


          @if(session('success'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
          @endif
                          






          <form action=" {{ url('send-forgotpassword-link') }} " method="post">
            @csrf
            <div class="input-group mb-3">              
              <input type="text" class="form-control" name="email" placeholder="Email" />
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            </div>
           
            <!--begin::Row-->
            <div class="row">
              
            <div class="d-flex gap-2">
               
                  <button type="submit" class="btn btn-danger">Send Link</button>  
                  <a href="{{ url('/') }}" ><button type="button"  class="btn btn-primary">Cancel</button></a>              
               
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