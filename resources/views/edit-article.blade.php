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
                      <textarea class="form-control" name="detail" id="detail" aria-label="With textarea">{!! old('detail', $article_detail->detail ?? '') !!}</textarea>
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

      <!--  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> -->
      
          
<!-- T3st_tiny# -->
 
    <script>



document.addEventListener("DOMContentLoaded", () => {

  /*
      ClassicEditor.create(document.querySelector('#detail'), {
        ckfinder: {
          uploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}"
        }       
        ,toolbar: [
            'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 
            '|', 'blockQuote', 'insertTable', 'codeBlock', 'undo', 'redo'
            ,'|','link', 'unlink', 'imageUpload', 'mediaEmbed'
            ,'|','code', 'codeBlock'
        ]
      })
      .catch(error => {
        console.error(error);
      });

      console.log(ClassicEditor.builtinPlugins.map(p => p.pluginName));
*/


      
    // 


    tinymce.init({
    selector: '#detail',  // change this value according to your HTML
    plugins: 'a_tinymce_plugin',
    a_plugin_option: true,
    a_configuration_option: 400,

    plugins: ['codesample', 'code'], // code= to see source code, codesample=to add code snipts.
    valid_elements: '*[*]',
    extended_valid_elements: '*[*]',
    toolbar: 'undo redo | bold italic underline | code | codesample ',
  forced_root_block: false,

  valid_children: '+body[style],pre[code]',

  license_key: 'gpl'   // Its important to include for free version.

  // apiKey: '4xv01v0utnwvff9jjtwb3upsv44w615mhs0szw4akw90z8tx',

  // Configure the code sample languages
  , codesample_languages: [
    {text: 'PHP', value: 'php'},
    {text: 'JavaScript', value: 'javascript'},
    {text: 'HTML/XML', value: 'markup'},
    {text: 'CSS', value: 'css'},
    {text: 'Python', value: 'python'}
  ],


  });


    // 

  });


</script>


@endsection      