@extends('layouts.userHeader')

@section('content')
<div class="container my-5 ">
   <div class="card">
      <div class="card-body">
          @foreach ($orders as $order)


          @foreach ( $order->order_products  as $product_item )
          {{-- {{ $product_item->id }} --}}
        <?php
         $product = $product_item->product
        ?>

        {{-- <p>{{ $product }}</p> --}}

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
                        <input type="hidden" name="orderId" value="{{ $order->id }}">
                        <input type="hidden" name="productId" value="{{ $product->id }}">
                        <button class="input-group-text decrement-btn" name="btn" value="minus" >-</button>
                    </form>
                    <input type="text" name="quantity" class="form-control qty-input text-center" value="{{ $product_item->quantity }}">
                    <form action="{{ route('cart.update',$product_item->id) }}" method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="orderId" value="{{ $order->id }}">
                        <input type="hidden" name="productId" value="{{ $product->id }}">
                        <button class="input-group-text increment-btn" name="btn" value="plus">+</button>
                    </form>
                 </div>
            </div>
            <div class="col-md-3">
                  <h3>{{ $product->price }}</h3>
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
                        $totalPrice += $product_item->product->price;
                    }
                }
                echo  $totalPrice;
                ?>
            </span>
        </h3>



          <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" rows="3"></textarea>
          </div>


   <div class="form-group">
         <label for="Room" class="my-3">Room</label>
          <select id="Room" class="form-select form-select-sm" aria-label=".form-select-sm example">
             <option selected disabled>Select your room</option>
             <option value="1">One</option>
             <option value="2">Two</option>
             <option value="3">Three</option>
          </select>
          </div>


          <div>



            <button class="btn btn-success">Confirm</button>
         </div>

      </div>

   </div>

</div>



@endsection
