@extends( ($user->role == 'user') ? 'layouts.userHeader' : 'layouts.adminHeader')

@section('content')
<div class="container">


    <a href="{{route('category.create')}}" class="btn btn-success">Add new category </a>
    <h1> All category  </h1>
    <table class="table">
        <thead>
            <tr> <th> Id</th> <th> Name </th>  <th>Show</th> <th> Edit </th> <th> Delete</th></tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td> {{$category->id}}</td>
                    <td> {{$category->name}}</td>
                    <td> <a href="{{route('category.show', $category->id)}}" class="btn btn-info"> Show </a></td>
                    <td> <a href="{{route('category.edit', $category->id)}}" class="btn btn-warning"> Edit </a></td>
                    <td>
                        <form action="{{route('category.destroy', $category->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <input type="submit"   class="btn btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>


            @endforeach

        </tbody>
        

    </table>
    {{ $categories->onEachSide(5)->links() }}
</div>
@endsection





    

