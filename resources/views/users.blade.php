@extends('components.layout.master')

@section('content')

@php
use Illuminate\Support\Str;
@endphp

<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Users</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                
                <li class="breadcrumb-item active" aria-current="page"><a href=" {{ url('userregisteration') }} ">Add New User</a></li>

                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-12">
                <!-- Default box -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Users List</h3>
                    <div class="card-tools">
                      <button
                        type="button"
                        class="btn btn-tool"
                        data-lte-toggle="card-collapse"
                        title="Collapse"
                      >
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                      <button
                        type="button"
                        class="btn btn-tool"
                        data-lte-toggle="card-remove"
                        title="Remove"
                      >
                        <i class="bi bi-x-lg"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">

                  @if ($errors->any())
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif


                  @if(session('success'))
                      <div class="alert alert-success">
                          {{ session('success') }}
                      </div>
                  @endif
                                

                  <table id="userlist" class="display">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Usser Name</th>                        
                        <th>Permissions</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
        <tbody>


        @foreach( $users  as $user)
          <tr>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email ? $user->email : 'NA' }}</td>
              <td>{{ $user->username  }}</td>
              <td>

                @foreach( $user->role  as $roleitem)                  
                  <span class="badge text-bg-success"> {{ $roleitem->role }} </span>
                @endforeach

              </td>
              <td>{!! $user->status ? '<span class="badge text-bg-success"> Active </span>' : '<span class="badge text-bg-danger"> InActve </span>'  !!}</td>
              <td>
                
                <a href="{{ url('user/gettoken/'.$user->id) }}"><span class="badge text-bg-dark"> <i class="nav-icon bi bi-pen"></i>  GetToken </span></a>
                
                @can('update', $user)
                <a href="{{ url('user/edit/'.$user->id) }}"><span class="badge text-bg-warning"> <i class="nav-icon bi bi-pen"></i>  Edit</span></a>
                @endcan

                @can('delete', $user)
                <a href="{{ url('user/delete/'.$user ->id) }}" onclick=" return confirm('You want to delete this User!')"><span class="badge text-bg-danger"> <i class="nav-icon bi-trash"></i> Delete</span></a>
                @endcan

              </td>
              
          </tr>

        @endforeach

        </tbody>
        <!-- <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot> -->
    </table>
                    


    



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Popup from Controller</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



                    
                </div>
                  <!-- /.card-body -->
                  <div class="card-footer">Footer</div>
                  <!-- /.card-footer-->
                </div>
                <!-- /.card -->
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
@endsection      


<script>

  
document.addEventListener("DOMContentLoaded", () => {
    new DataTable('#userlist');

});



</script>