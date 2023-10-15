@extends(Auth::User() == null ? 'layouts.userHeader' : (Auth::User()->role == 'admin' ? 'layouts.adminHeader' : 'layouts.userHeader'))


@section('content')
<section style="padding-top: 50px;">
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 text-center">
             <h1 style="font-size: 150px;">404</h1>
             <h2>Page Not Found</h2>
             <p>The page you requested could not found!</p>
             <a href="/" class="btn btn-outline-primary">Back To Home Page</a>
        </div>
    </div>
</div>

</section>



@endsection
