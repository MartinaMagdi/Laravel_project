@extends(Auth::User() == null ? 'layouts.userHeader' : (Auth::User()->role == 'admin' ? 'layouts.adminHeader' : 'layouts.userHeader'))

@section('content')
<section style="padding-top: 50px;">
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 text-center">
             <h1 style="font-size: 150px;">403</h1>
             <h2> Not Authorized</h2>
             <p>You Are Not an Admin!</p>
             <a href="/" class="btn btn-outline-primary">Back To Home Page</a>
        </div>
    </div>
</div>

</section>



@endsection
