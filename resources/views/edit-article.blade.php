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
              <div class="col-sm-6"><h3 class="mb-0">Article</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><a href=" {{ url('articles') }} ">Articles List</a></li>
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
                    <h3 class="card-title">Edit Title</h3>
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

                  
                    @if(isset( $article_detail->id  ))
                    <input type="hidden" name="id" value="{{ $article_detail->id }}" >
                   @endif

                    <!--begin::Body-->
                    <div class="card-body">

                   

                      <div class="mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">Article Title</label>
                        <input type="name" name="article_title" class="form-control"  value="{{ old('article_title', $article_detail->article_title ?? '') }}"  id="category_name" >
                                             
                      </div>
                      
                      <div class="mb-3">
                        <div class="input-group">
                        <span class="input-group-text">Article Sub-title</span>
                        <textarea class="form-control" name="article_sub_title" id="article_sub_title" aria-label="With textarea">{{ old('article_sub_title', $article_detail->article_sub_title ?? '') }}</textarea>
                        </div>
                      </div>

                    

                      <div class="mb-3 ">
                      <label for="exampleInputEmail1" class="form-label">Description </label>
                      <textarea class="form-control" name="detail" id="detail" aria-label="With textarea">{{ old('detail', $article_detail->detail ?? '') }}</textarea>
                      </div>



                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Categories </label> <br/> 
                        <span class="list_of_checkboxs" > 
                          @foreach($categories as $k=>$v)
                            
                              <div class="form-check" >
                                  <input class="form-check-input" type="checkbox" {{ in_array( $k, $articles_categories_ids) ? "checked ": "" }}  id="categories" name="categories[]" value="{{$k}}">
                                  
                                  <label class="form-check-label" for="categories">{{$v}}</label>
                            </div>

                          @endforeach
                        </span>
                      </div>

                      <div class="mb-3 ">
                      <label for="exampleInputEmail1" class="form-label">Article Status</label>
                        <span class="list_of_checkboxs" >                            
                            <select class="form-select" name="status" id="status" >
                            @foreach($status as $k=>$v)
                            <option value="{{$k}}">{{$v}}</option>
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

    

      <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    <script>
    ClassicEditor.create(document.querySelector('#description'), {
    ckfinder: {
       uploadUrl: '{{ route('upload', ['_token' => csrf_token()]) }}'
    }
    })
    .catch(error => {
    console.error(error);
    });
    </script>

@endsection      