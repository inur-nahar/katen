@extends('layouts.backend_master')
@section('main_content')
<div class="row">
    <div class="col-12">
        <div class="card-style mb-30">
            <h4 class="mb-25">Add New Post</h4>
            <form action="{{ route('post.store') }}" class="row" method="POST" enctype="multipart/form-data">
                @csrf
<div class="col-lg-12">
    <div class="input-style-1">
        <label>Title</label>
    <input type="text" placeholder="Title" name="title" value="{{ old('title') }}">
    @error('title')
<p class="text-danger">{{ $message }}</p>
    @enderror
      </div>
</div>
<div class="col-lg-6">
    <div class="select-style-1">
        <label>Category</label>

        <div class="select-position" >

          <select name="category" id="category" >
            <option value="" selected disabled>Select category</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }} </option>
            @endforeach
         </select>
        </div>
        @error('category')
        <p class="text-danger">{{ $message }}</p>
            @enderror
      </div>
         </div>
         <div class="col-lg-6">
            <div class="select-style-1">
                <label>Sub Category</label>
                <div class="select-position">
                  <select name="subcategory" id="subcategory">
                    <option selected disabled>No Sub Category Found</option>

                  </select>
                </div>
                @error('subcategory')
                <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
                 </div>

                 <div class="col-lg-12">
                    <div class="input-style-1">
                        <label>Featured Image</label>
                        <input type="file" name="featured_image" >
                        @error('featured_image')
                        <p class="text-danger">{{ $message }}</p>
                            @enderror
                      </div>
                 </div>
                 <div class="col-lg-12">
                    <div class="input-style-1">
                        <label> Description</label>
                        <textarea id="post_description_editor" placeholder="Description" name="description" ></textarea>
                        @error('description')
                        <p class="text-danger">{{ $message }}</p>
                            @enderror
                      </div>
                 </div>
                 <div class="col-lg-12">
                    <div class="input-style-1">
                        <label>Short Description</label>
                        <textarea  placeholder="Short Description" name="short_description" value="{{ old('short_description') }}"></textarea>
                        @error('short_description')
                        <p class="text-danger">{{ $message }}</p>
                            @enderror
                      </div>
                 </div>
                 <div class="col-lg-12">
                    <button class="main-btn primary-btn btn-hover w-100" type="submit" >
                        Add New Post
                    </button>
                 </div>
            </form>
               </div>
         </div>
</div>
@endsection
@push('additional-css')
<style>
    .ck-editor__editable[role="textbox"] {
                /* editing area */
                min-height: 200px;
            }
</style>
@endpush
@push('additional-js')
<script src="{{ asset('backend/assets/js/ckeditor.js') }}">
</script>

    <script>
    ClassicEditor
        .create( document.querySelector( '#post_description_editor' ) )
        .catch( error => {
            console.error( error );
        } );
        $('#category').on('change', function(){
            $.ajax({
    url:`{{ route('subcategory.getSubcategory') }}`,
    method:'GET',
    data:{
        category: $(this).val()
    },
    success: function(res){
      if(res.length > 0){
        let options =[
          `<option selected disabled>select subcategory</option>`
        ];
res.forEach(function(subcategory){
let option = `<option value= "${subcategory.id}">${subcategory.name}</option>`;
options.push(option);
    });
$('#subcategory').html(options)
      }else{
        $('#subcategory').html(`<option selected disabled>No Sub Category Found!</option>`)

      }

    }
})

        })
</script>

@endpush
