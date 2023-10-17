@extends('layouts.adminHeader')

@section('content')
   <div class="container">
<h1>Edit Category</h1>

<form method="POST"  action="{{route('categories.update', $category->id)}}">
    @csrf
    @method('put')
    <div class="mb-3">
            <input type="hidden" class="form-control" name="id"  value="{{$category->id}}">
         
    </div>
    <div class="mb-3">
            <label  class="form-label">Name</label>
            <input type="text" class="form-control" name="name"  value="{{$category->name}}">
            @error('name')
                <div style="color: red; font-weight: bold"> {{$message}}</div>
            @enderror
    </div>

   
   

    <button class="btn btn-success" type="submit">Update Category</button>
</form>

</div>
@endsection