@extends( ($user->role == 'user') ? 'layouts.userHeader' : 'layouts.adminHeader')

@section('content')
<div class="container">
    edit profile
</div>
@endsection
