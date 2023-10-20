@extends('layouts.userHeader')

@section('content')
    <div class="container my-5 ">
        <h1>Cart</h1>
        <div class="card">
            <div class="card-body">
                @foreach ($orders as $order)
                    @foreach ($order->order_products as $product_item)
                        <?php
                        $product = $product_item->product;
                        ?>
                        <div class="row flex align-items-center">
                            <div class="col-md-4">
                                <h3>{{ $product->name }}</h3>
                            </div>
                            <div class="col-md-3">
                                <label for="Quantity">Quantity</label>
                                <div class="input-group text-center mb-3" style="width:130px;">
                                    <form action="{{ route('cart.update', $product_item->id) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="input-group">
                                            <button class="input-group-text decrement-btn"
                                                name="btn-{{ $product_item->id }}">-</button>
                                            <input type="text" id="myInput-{{ $product_item->id }}" name="quantity"
                                                value="{{ $product_item->quantity }}"
                                                class="form-control text-center text-danger myInput">
                                            <button class="input-group-text increment-btn"
                                                name="btn-{{ $product_item->id }}">+</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h3>{{ $product->price * $product_item->quantity }}</h3>
                            </div>
                            <div class="col-md-2">
                                <form action="{{ route('cart.destroy', $product_item->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger">X</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endforeach
                <h3 class="my-5 me-4  align-self-end" style="display: flex; justify-content: flex-end;">
                    total price :
                    <span class="text-primary h2 fw-bold">
                        <?php
                        $totalPrice = 0;
                        foreach ($orders as $order) {
                            $products = $order->order_products;
                            foreach ($products as $product_item) {
                                $totalPrice += $product_item->product->price * $product_item->quantity;
                            }
                        }
                        echo $totalPrice;
                        ?>
                    </span>
                </h3>
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    @foreach ($orders as $order)
                        <input type="hidden" name="orders[]" value="{{ $order->id }}">
                    @endforeach
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" rows="3" name="client_note"></textarea>
                    </div>
                    <div class="flex">
                        <p class="fs-3 text-primary"> Room: {{ Auth::user()->room }}</p>
                    </div>
                    <div>
                        <input type="submit" value="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var incrementBtns = document.querySelectorAll('.increment-btn');
        var decrementBtns = document.querySelectorAll('.decrement-btn');
        var inputFields = document.querySelectorAll('.myInput');

        incrementBtns.forEach(function(btn, index) {
            btn.addEventListener('click', function() {
                var value = parseInt(inputFields[index].value);
                inputFields[index].value = value + 1;
            });
        });

        decrementBtns.forEach(function(btn, index) {
            btn.addEventListener('click', function() {
                var value = parseInt(inputFields[index].value);
                if (value > 0) {
                    inputFields[index].value = value - 1;
                }
            });
        });
    });
</script>
