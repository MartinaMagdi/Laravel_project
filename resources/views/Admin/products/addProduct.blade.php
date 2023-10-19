@extends('layouts.adminHeader')

@section('content')
    <div class="container">
        <h3 class="text-center fw-bold mb-5"><span class="text-primary fs-1">Add</span> new product</h3>

        <form method="post" action="{{ route('products.store') }}" class="w-75 mx-auto" enctype="multipart/form-data">
            @csrf
            <div class="form-row row">
                <div class="col-12">
                    <label for="name" class="fw-bold mb-2">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="product name"
                        value="{{ old('name') }}">

                    @error('name')
                        <small style="color: red" class="mb-4">{{ $message }}</small>
                    @enderror
                </div>


                <div class="col-12 mt-4">
                    <label for="price" class="fw-bold mb-2">Price</label>
                    <input type="number" id="price" name="price" min="1" class="form-control"
                        placeholder="product price" value="{{ old('price') }}">

                        @error('price')
                            <small style="color: red" class="mb-4">{{ $message }}</small>
                        @enderror
                </div>


                <div class="col-12 col-md-6 mt-4">
                    <label for="category" class="fw-bold mb-2">Category</label>
                    <select class="form-select" name="category_id" aria-label="Default select example" id="category">
                        <option selected disabled>Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    @error('category')
                        <small style="color: red" class="mb-4">{{ $message }}</small>
                    @enderror
                </div>


                <div class="col-12 col-md-6 mt-4 d-flex align-items-end">
                    <a href="{{route('categories.create')}}" class="fs-5 fw-medium">Add category</a>
                </div>

                <div class="col-12 mt-4">
                    <label for="image" class="fw-bold mb-2">Image</label>
                    <input class="form-control" type="file" id="image" name="image" value="{{ old('image') }}">
                    
                    @error('image')
                        <small style="color: red" class="mb-4">{{ $message }}</small>
                    @enderror
                </div>


                <div class="col-12 mt-4">
                    <input type="checkbox" class="btn-check" id="available" name="available" value="true"
                        {{ old('available') == 'true' ? 'checked' : '' }}>
                    <label class="btn btn-outline-primary" for="available">Make it available</label>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary px-5 fs-5 mt-5">Add</button>
                </div>
            </div>
        </form>
    </div>
    </div>
<div class="container">
    add product
</div>
@endsection
