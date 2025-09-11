@extends('components.layout.master')




@section('content')
<style>
.form-check
{
  display: inline-block;
  margin-right: 10px;
}

</style>

<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">User</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><a href=" {{ url('usersList') }} ">User</a></li>
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
              <div class="col-6">
                <!-- Default box -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Edit User</h3>
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
                                

                  <form method="post" action="{{ url('user-update') }}">
                    @csrf

                    <!--begin::Body-->
                    <div class="card-body">

                        @if(isset( $users->id  ))
                          <input type="hidden" name="id" value="{{ $users->id }}" >
                        @endif

                      <div class="mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">Full Name</label>
                        <input type="name" name="name" class="form-control"  value="{{ old('name', $users->name) }}"  id="name" >
                                             
                      </div>
                      
                      <div class="mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"  value="{{ old('email',  $users->email) }}"  id="email" >
                                             
                      </div>


                      <div class="mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">User Name</label>
                        <input type="text" name="username" class="form-control" readonly disabled  value="{{ old('username',   $users->username ) }}"  id="username" >
                                             
                      </div>

                    

                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Scope </label> <br/>
                        <span class="list_of_checkboxs" > 
                          @foreach($roles_list as $role)
                           
                              <div class="form-check">
                                  <input class="form-check-input " value="{{$role->id}}"   {{ in_array( $role->id , $roles_currently_assigned ) ? 'checked': '' }} type="checkbox" id="roles" name="roles[]"  >
                                  <label class="form-check-label" for="roles">{{$role->role}}</label>                            
                            </div>

                          @endforeach
                        </span>
                      </div>

                     



                      

                      <div class="mb-3 ">
                      <label for="exampleInputEmail1" class="form-label">User Status  label>
                        <span class="list_of_checkboxs" >                            
                            <select class="form-select" name="status" id="status" >
                            @foreach($status as $k=>$v)
                            <option {{ ($users->status==$k) ? "selected": '' }} value="{{$k}}">{{$v}}</option>
                            @endforeach
                            </select>
                        </span>
                      </div>

                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <!--end::Footer-->
                  </form>
                  
                    




                    
                </div>
                  <!-- /.card-body -->
                  <div class="card-footer">Footer</div>
                  <!-- /.card-footer-->
                </div>
                <!-- /.card -->
              </div>

              <div class="col-6">
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>

    

      

@endsection      