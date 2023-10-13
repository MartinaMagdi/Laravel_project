@extends('layouts.adminHeader')

@section('content')
   
<h1> Create New Category</h1>

<form method="post"  action="{{route('category.store')}}" >
    @csrf
    <div class="mb-3">
            <label  class="form-label">Name</label>
            <input type="text" class="form-control" name="name" >
            @error('name')
                <div style="color: red; font-weight: bold"> {{$message}}</div>
            @enderror
    </div>


    <button type="submit" class="btn btn-primary">Submit</button>
</form>


@endsection