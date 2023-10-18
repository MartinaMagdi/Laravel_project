@extends('layouts.adminHeader')

@section('content')
<div class="container"  >
    <a class="btn btn-success" href="{{route('user.create')}}"> Add User</a>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>Email</th>
            <th>Room</th>
            <th>Google_id</th>
            <th>Action</th>
        </tr>
    @foreach($users as $user)
    @if($user->role == "admin")
    @else
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->role}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->room}}</td>
            <td>{{$user->google_id}}</td>
            <td class="d-flex">
                <a href="{{ route('user.edit',$user->id) }}" class="btn btn-primary me-3">Edit</a>

                <form  action="{{route('user.destroy',$user->id )}}" method="post">
                @csrf
                @method('delete')
                    <button type="submit" class="btn btn-danger" > Delete</button>
                </form>
            </td>

        </tr>
        @endif
    @endforeach
    </table>
</div>
@endsection
