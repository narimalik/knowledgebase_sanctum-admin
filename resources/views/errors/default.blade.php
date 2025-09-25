@extends('components.layout.error')

@section('pageTitle')
404 Page
@endSection

@section('errorcontent')


<div class="login-box">
      <div class="login-logo">
        <a href="{{ url('/') }}"><b>Error </b>Page!</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12 text-center">
                            <h1 class="display-1 text-danger">{{ $exception->getStatusCode() ?? 'Error' }}</h1>
                            <h3><i class="fas fa-bug text-warning"></i> {{ $exception->getMessage() ?: 'Something went wrong!' }}</h3>
                            
                            <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-home"></i> Go Home
                            </a>
                        </div>
                    </div>
                </div>
            </section>
          </div>    
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>

@endsection