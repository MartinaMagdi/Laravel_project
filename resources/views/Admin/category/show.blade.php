@extends('layouts.adminHeader')

@section('content')



<div class="card ">
                <div class="card-header">Category</div>

 
                <div class="card-body">
               ID:  {{$category->id}}
                </div>

                <div class="card-body">
                Name:  {{$category->name}}
                </div>

                <div class="card-body">
              created at :  {{$category->created_at}}
                </div>
                <div class="card-body">
              updated at :  {{$category->updated_at}}
                </div>
                <div class="card-body">
                <a href="{{route('category.index')}}"  class="btn btn-info">Back To Categories</a>
                </div>

 </div>



@endsection
