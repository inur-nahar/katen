@extends('layouts.backend_master')

@section('main_content')
<div class="row">

</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card-style mb-30">
            <h6 class="mb-10">All Categories</h6>
    <div class="table-wrapper table-responsive">
              <table class="table striped-table text-center">
                <thead>
                  <tr>
                    <th>SL. No.</th>
                    <th>
                        <h6>Name</h6>
                      </th>
                    <th>
                      <h6>Slug</h6>
                    </th>
                    <th>
                        <h6>Parent Category</h6>
                      </th>
                    <th>
                      <h6>Status</h6>
                    </th>

                    <th>
                      <h6>Action</h6>
                    </th>
                  </tr>
                  <!-- end table row-->
                 </thead>
                <tbody>
            @forelse ($subcategories as $key=> $subcategory )
            <tr>
                <td>
                  <h6 class="text-sm">#{{$subcategories->firstItem()+$key }}</h6>

                </td>
                <td>
                  <p>{{ $subcategory->name }}</p>
                </td>
                <td>
                  <p>{{ $subcategory->slug }}</p>
                </td>
                <td>
                    <p>{{ $subcategory->category->name}}</p>
                  </td>

                <td>
                    <div class="form-check form-switch toggle-switch">
                        <input class="form-check-input" type="checkbox" id="toggleSwitch2" {{$subcategory->status ? 'checked':''}}>

                      </div>
                </td>
                <td>
                    <a href="{{ route('subcategory.edit',$subcategory->id) }}" class="btn-sm main-btn info-btn btn-hover">
                        <i class="lni lni-pencil-alt"></i>
                    </a>
                    <button  class="btn-sm main-btn danger-btn btn-hover delete_btn">
                        <i class="lni lni-trash-can"></i>
                    </button>
                       <form method="POST" action="{{ route('subcategory.delete',$subcategory->id) }}">
                        @method('DELETE')
                        @csrf

                       </form>

                </td>
              </tr>
            @empty
<tr>
    <td colspan='5' class="text-center text-danger"><strong>No Data Found!</strong></td>
</tr>
            @endforelse

                  <!-- end table row -->

                </tbody>
              </table>
              <!-- end table -->
            </div>
            <div>
                {{ $subcategories->links() }}
            </div>
          </div>

    </div>

<div class="col-lg-4">
    <div class="card-style mb-30">
        <h6 class="mb-25">{{ isset($editdata) ?'Update Category' :'Create new' }} Sub Category</h6>
 <form action="{{ isset($editdata) ? route('subcategory.update', $editdata->id) :route('subcategory.store') }}" method="POST">
    @isset($editdata)
        @method('PUT')
    @endisset
    @csrf
    <div class="select-style-1">
        <label>Category</label>
        <div class="select-position">
          <select name="category">
            <option >Select category</option>
            @foreach ($categories as  $category )
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach

          </select>
        </div>
        @error('category')
<p class="text-danger">{{ $message }}</p>
        @enderror
      </div>
<div class="input-style-1">
        <label> Sub Category Name</label>
        <input type="text" name="name" placeholder="Enter SubCategory Name" value="{{ isset($editdata) ? $editdata->name:'' }}">
        @error('name')
<p class="text-danger"> {{ $message }}</p>
        @enderror
      </div>

      <button type="submit" class="main-btn primary-btn btn-hover w-100 btn-sm">{{ isset($editdata) ?'Update Category' :'Create new ' }}Sub Category</button>
</form>

</div>
</div>
@endsection
@push('additional-js')
<script src="{{ asset('backend/assets/js/sweetalert2@11.js') }}"></script>
<script>

$('.delete_btn').on('click',function(){
    Swal.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes, delete it!"
}).then((result) => {
  if (result.isConfirmed) {
    $(this).next('form').submit();
  }
});
})

</script>

@endpush

