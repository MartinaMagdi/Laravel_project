@extends(Auth::User() == null ? 'layouts.userHeader' : (Auth::User()->role == 'admin' ? 'layouts.adminHeader' : 'layouts.userHeader'))

@section('content')
    <div>
        <h2 class="text-center">My Profile</h2>

  

        <section style="background-color: #eee;">
  <div class="container py-5">
 
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
    @if ($user->image)
        <img src="{{asset('images/avatars/'.$user->image)}}" class="rounded-circle img-fluid" style="width: 150px;" alt="Profile Image" width="150">
        @else
        <p>No image uploaded</p>
    @endif

           
              <h5 class="my-3">{{ $user->name }}</h5>
            <p class="text-muted mb-1">Full Stack Developer</p>
            <div class="d-flex justify-content-center  mb-2">
            <a href="{{ route('profile.edit',$user->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('changepassword.edit', $user->id) }}" class="btn btn-primary ms-4">change Password</a>
            
          </div>
          </div>
        </div>
       
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->name }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->email }}</p>
              </div>
            </div>
            <hr>
            
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Room</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->room }}</p>
              </div>
            </div>
          </div>
        </div>
     
      </div>
    </div>
  </div>
</section>

    </div>
@endsection