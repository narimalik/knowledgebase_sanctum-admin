@extends('components.layout.master')

@section('content')
<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Category</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><a href=" {{ url('category') }} ">Category List</a></li>
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
                    <h3 class="card-title">New Category</h3>
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

                   

                  <form method="post" action="{{ url('category-save') }}">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Category Name</label>
                        <input type="name" name="category_name" class="form-control" id="category_name" aria-describedby="emailHelp">
                        
                        <!-- <div id="emailHelp" class="form-text">
                          We'll never share your email with anyone else.
                        </div> -->
                      </div>
                      
                      <div class="mb-3">
                        <div class="input-group">
                        <span class="input-group-text">Category Detail</span>
                        <textarea class="form-control" name="category_detail" id="category_detail" aria-label="With textarea"></textarea>
                        </div>
                      </div>

                    

                      <div class="mb-3 form-check">
                      <label for="exampleInputEmail1" class="form-label">Category Name</label>
                        <span class="list_of_checkboxs" >
                            <input type="checkbox" value="val1" name="paraent_category[]">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </span>

                        <span class="list_of_checkboxs" >
                            <input type="checkbox" value="val2"  name="paraent_category[]">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </span>

                        <span class="list_of_checkboxs" >
                            <input type="checkbox" value="val3"  name="paraent_category[]">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
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
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
@endsection      