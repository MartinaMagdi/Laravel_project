@extends('layouts.userHeader')

@section('content')
    <style>
        .collapse {
            display: none;
        }
    </style>

    <div class="container">
        <p class="h2 fw-bold mb-3">my orders</p>
        <form action="{{ route('orders.index') }}" class="form-pick-date form-inline" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="startDate" class="fs-5">Start Date</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" min="<?php echo date('Y-m-d', strtotime('-4 year')); ?>"
                            max="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="endDate" class="fs-5">Until</label>
                        <input type="date" class="form-control" id="endDate" name="endDate" max="<?php echo date('Y-m-d', strtotime('+1 year')); ?>">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </form>

        <div class="content">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Order date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        @foreach ($order->order_products as $pro)
                        @endforeach
                        <tr>
                            <td>
                                <p style="display: inline; margin-right: 10px;">{{ $order->created_at }} </p>
                                <button onclick="toggleCollapse({{ $order->id }})" id="btn-collapse-{{ $order->id }}">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </td>

                            <td>{{ $order->status }} </td>
                            <td>
                                <?php
                                $products = $order->order_products;
                                $sumOfPrice = 0;
                                foreach ($products as $product_item) {
                                    $sumOfPrice += $product_item->product->price;
                                }
                                echo $sumOfPrice;
                                ?>
                            </td>


                            <td>

                                @if ($order->status != 'done')
                                    <form action="{{ route('orders.destroy', $order) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="submit" value="Cancel" name="submit-delete">
                                    </form>
                                @endif

                            </td>

                        </tr>

                        <div class="collapse" id="myCollapse-{{ $order->id }}">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 mt-4">
                                @foreach ($order->order_products as $product_item)
                                    <div class="col mb-4">
                                        <div class="card">
                                            <img src="{{ asset('images/products/' . $product_item->product->image)}}" alt="Product Image"
                                            class="card-img-top" style="height: 220px">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">{{ $product_item->product->price }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach


                </tbody>
            </table>
            <div class="price">
                <p class="fw-bold fs-3">
                    price
                </p>
                <div class="price">
                    <p class="fw-bold fs-3" style="display: inline; margin-right: 30px;">
                        Total price :
                    </p>
                    <p class="total-price fw-bold fs-3 text-primary" style="display: inline; margin-right: 10px;">
                        <?php
                        $totalPrice = 0;
                        foreach ($orders as $order) {
                            $products = $order->order_products;
                            foreach ($products as $product_item) {
                                $totalPrice += $product_item->product->price;
                            }
                        }
                        echo $totalPrice;
                        ?>
                    </p>
                </div>

            </div>

        </div>
    </div>

    <script>
        function toggleCollapse(orderId) {
            console.log('clicked');
            let collapseElement = document.getElementById("myCollapse-" + orderId);
            let collapseBtn = document.getElementById("btn-collapse-" + orderId);

            if (collapseElement.style.display === "none") {
                collapseElement.style.display = "block";
                collapseBtn.innerHTML = '<i class="bi bi-dash"></i>';
            } else {
                collapseElement.style.display = "none";
                collapseBtn.innerHTML = '<i class="bi bi-plus-lg"></i>';
            }
        }
    </script>
@endsection
