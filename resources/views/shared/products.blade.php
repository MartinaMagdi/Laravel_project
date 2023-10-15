@extends(Auth::User() == null ? 'layouts.userHeader' : (Auth::User()->role == 'admin' ? 'layouts.adminHeader' : 'layouts.userHeader'))

@section('content')
    <div class="container">
        {{-- -------------------------------------- Search field ---------------------------------------- --}}
        <div class="input-group mb-3 w-25 ms-auto">
            <form method="post" action="{{ route('products.search') }}" class="d-flex w-100">
                @csrf
                <input type="text" class="form-control" required name="search" placeholder="search for a product"
                    aria-label="search for a product" aria-describedby="basic-addon1">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        {{-- --------------------------------- Section for Admin only ------------------------------------ --}}
        @if (Auth::User() !== null && Auth::User()->role == 'admin')
            <div>
                <a href={{ route('products.create') }} class="btn btn-primary ms-auto d-block w-25">Add Product</a>

                {{-- Alert --}}
                @if (Session::get('status') == 'delted' || Session::get('status') == 'updated')
                    <div class="alert alert-dismissible fade show mt-4 {{ Session::get('status') == 'deleted' ? 'alert-danger' : 'alert-success' }}"
                        role="alert">
                        <i
                            class="bi bi-check fs-5 rounded-circle text-white px-1 me-1 {{ Session::get('status') == 'deleted' ? 'bg-danger' : 'bg-success' }}"></i>
                        <strong>{{ Session::get('message') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="mt-4 w-50 mx-auto">
                    <label for="user" class="mb-1 fs-5 fw-bold">Add order to user</label>
                    <select id="user" class="form-select" aria-label="Default select example">
                        <option selected disabled>Select a user</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif


        {{-- Serach aleart if there is no products matched --}}
        @if (Session::has('status'))
            <div class="alert alert-dismissible fade show mt-4 {{ Session::get('status') == 'notMatched' ? 'alert-info' : '' }}"
                role="alert">
                <i
                    class="bi bi-x fs-5 rounded-circle px-1 me-1 {{ Session::get('status') == 'notMatched' ? 'bg-info' : '' }}"></i>
                <strong>{{ Session::get('message') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- -------------------------------------- Products section ---------------------------------------- --}}
        <div class="products mt-5">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-12 col-md-6 col-lg-4 mb-5">
                        <div class="card bg-white">
                            @if (Auth::User() !== null && Auth::User()->role == 'admin')
                                @if ($product->available)
                                    <p class="bg-success text-white fx-5 py-1 px-2 rounded my-1 ms-auto d-block m-1">
                                        Available</p>
                                @else
                                    <p class="bg-danger text-white fx-5 py-1 px-2 rounded my-1 ms-auto d-block m-1">Not
                                        available</p>
                                @endif
                            @endif
                            <img max-height="100px" height="300px" width="100%"
                                src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" />

                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary fs-3 p-2">{{ $product->name }}
                                </h5>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <span class="fs-4 fw-bold">{{ $product->price }} LE</span>
                                <div class="actions d-flex">
                                    @if ($product->available == true)
                                        <a href="#" class="btn btn-success me-1">
                                            <i class="bi bi-cart-plus"></i>
                                        </a>
                                    @endif
                                    @if (Auth::User() !== null && Auth::User()->role == 'admin')
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="{{ route('products.destroy', $product->id) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger" type="submit">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="ms-auto" style="width: fit-content">{{ $products->links() }}</div>
    </div>
@endsection
