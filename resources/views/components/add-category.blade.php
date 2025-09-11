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
              <div class="col-6">
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
                                

                  <form method="post" action="{{ url($url) }}">
                    @csrf

                   @if(isset( $cateogry_detail->id  ))
                    <input type="hidden" name="id" value="{{ $cateogry_detail->id }}" >
                   @endif


                    <!--begin::Body-->
                    <div class="card-body">

                   

                      <div class="mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">Category Name</label>
                        <input type="name" name="category_name" class="form-control"  value="{{ old('category_name', $cateogry_detail->category_name ?? '') }}"  id="category_name" >
                                             
                      </div>
                      
                      <div class="mb-3">
                        <div class="input-group">
                        <span class="input-group-text">Category Detail</span>
                        <textarea class="form-control" name="category_detail" id="category_detail" aria-label="With textarea">{{ old('category_detail', $cateogry_detail->category_short_detail ?? '') }}</textarea>
                        </div>
                      </div>

                    

                      <div class="mb-3 ">
                      <label for="exampleInputEmail1" class="form-label">Parent Category </label>
                        <span class="list_of_checkboxs" >                         
                            <select class="form-select" name="paraent_category" id="paraent_category" >
                             <option value="0">-- Select --</option>
                              @foreach($categories as $i=>$v)  
                              <option {{ isset($cateogry_detail) && $cateogry_detail->parent_category_id == $i ? 'selected': '' }} value="{{ $i }}">{{ $v }}</option>
                              @endforeach
                            </select>
                        </span>
                      </div>



                      
                      <div class="mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">Category Icon CSS</label>
                        <input type="name" name="category_icon_css" class="form-control"  value="{{ old('category_icon_css', $cateogry_detail->category_icon_css ?? '') }}"  id="category_icon_css" >
                                             
                      </div>


                      <div class="mb-3 ">
                      <label for="exampleInputEmail1" class="form-label">Category Status</label>
                        <span class="list_of_checkboxs" >                            
                            <select class="form-select" name="status" id="status" >
                            @foreach($status as $i=>$v)  
                            <option  {{ isset($cateogry_detail) && $cateogry_detail->status==$i ? 'selected' : '' }} value="{{ $i }}">{{ $v }}</option>
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