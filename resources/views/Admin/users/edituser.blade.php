@extends('layouts.adminHeader')

@section('content')
    <div class="container">
        <h2 class="text-center">Edit User</h2>

        <form method="post" action="{{ route('user.update',$user->id) }}"  enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mb-3">
        <label  class="form-label">Name</label>
        <input type="text" class="form-control" name="name" value="{{ $user->name }}" >
    </div>

    <div class="mb-3">
        <label  class="form-label">email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="form-control"  aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label  class="form-label">room</label>
        <input type="text" name="room" class="form-control" value="{{ $user->room }}">
    </div>
  
    <div class="mb-3">
        <label  class="form-label">Image</label>
        <input type="file" name="image" class="form-control" value="{{ $user->image }}">
    </div>
  

          
            <!-- Other form fields -->

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection