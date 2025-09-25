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
                  <li class="breadcrumb-item active" aria-current="page"><a href=" {{ url('add-category') }} ">Add New Category</a></li>
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
                    <h3 class="card-title">Category List</h3>
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
                                

                  <table id="categorylist" class="display">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Details</th>
                        <th>Action</th>
                      
                    </tr>
                </thead>
        <tbody>


        @foreach( $data  as $category)        
          <tr>
              <td>{{ $category->category_name }}</td>
              <td>{{ $category->parent ? $category->parent->category_name : 'NA' }}</td>
              <td>{{ $category->category_short_detail	 }}</td>
              <td>
              <a href="{{ url('category/articles/'.$category->id) }}"><span class="badge text-bg-success"> <i class="nav-icon bi bi-list"></i> See Articles</span> </a>
                <a href="{{ url('category/edit/'.$category->id) }}"><span class="badge text-bg-warning"> <i class="nav-icon bi bi-pen"></i>  Edit</span></a>
                <a href="{{ url('category/delete/'.$category->id) }}" onclick=" return confirm('You want to delete this category!')"><span class="badge text-bg-danger"> <i class="nav-icon bi-trash"></i> Delete</span></a>
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


