@extends(Auth::User()->role == 'user' ? 'layouts.userHeader' : 'layouts.adminHeader')

@section('content')
    <div class="container">
        {{-- -------------------------------------- Search field ---------------------------------------- --}}
        <div class="input-group mb-3 w-25 ms-auto">
            <input type="text" class="form-control" placeholder="search for a product" aria-label="search for a product"
                aria-describedby="basic-addon1">
            <a href="" class="btn btn-primary">
                <i class="bi bi-search"></i>
            </a>
        </div>

        {{-- --------------------------------- Section for Admin only ------------------------------------ --}}
        @if (Auth::User()->role == 'admin')
            <div>
                <a href={{ route("products.create") }} class="btn btn-primary ms-auto d-block w-25">Add Product</a>
                <div class="mt-4 w-50 mx-auto">
                    <label for="user" class="mb-1 fs-5 fw-medium">Add order to user</label>
                    <select id="user" class="form-select" aria-label="Default select example">
                        <option selected disabled>Select a user</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        {{-- -------------------------------------- Products section ---------------------------------------- --}}
        <div class="products mt-5">
            <div class="row mb-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card bg-white">
                        <img src="..." class="card-img-top" alt="..." max-height="100px">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <span class="fs-4 text-primary fw-bold">10 LE</span>
                            <div class="actions">
                                <a href="#" class="btn btn-primary me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="#" class="btn btn-danger">
                                    <i class="bi bi-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
