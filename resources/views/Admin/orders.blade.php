@extends('layouts.adminHeader')

@section('content')
    <div class="container">

        <style>
            .collapse {
                display: none;
            }
        </style>

        <div class="container">
            <p class="h2 fw-bold mb-3">Orders</p>
            <form action="{{ route('admin.filter') }}" class="form-pick-date form-inline" method="get">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="startDate" class="fs-5">Start from</label>
                            <input type="date" class="form-control" id="startDate" name="startDate"
                                min="<?php echo date('Y-m-d', strtotime('-4 year')); ?>" max="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="endDate" class="fs-5">Until</label>
                            <input type="date" class="form-control" id="endDate" name="endDate"
                                max="<?php echo date('Y-m-d', strtotime('+1 year')); ?>">
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="name" class="fs-5">User name</label>
                            <input type="text" name="name" id="name" class="form-control">
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
                            <th scope="col">Name</th>
                            <th scope="col">Room</th>
                            <th scope="col">Note</th>
                            <th scope="col">Action</th>
                            <th scope="col">Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    <p style="display: inline; margin-right: 10px;">{{ $order->created_at }} </p>
                                    <button onclick="toggleCollapse({{ $order->id }})"
                                        id="btn-collapse-{{ $order->id }}">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </td>

                                <td>{{ $order->status }} </td>
                                <td>
                                    <?php
                                    $products = $order->order_products;
                                    $sumOfPrice = 0;
                                    foreach ($products as $product_item) {
                                        $sumOfPrice += $product_item->product->price * $product_item->quantity;
                                    }
                                    echo $sumOfPrice . " LE";
                                    ?>
                                </td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->user->room }}</td>
                                <td>{{ $order->note }}</td>

                                <td>
                                    @if ($order->status == 'done')
                                        <a href="">Cancel</a>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.update', $order) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <select name="status">
                                            <option value="processing">processing</option>
                                            <option value="out for delivery">out for delivery</option>
                                            <option value="done">done</option>
                                        </select>
                                        <button class="btn btn-primary ms-2" type="submit">update</button>
                                    </form>
                                </td>
                            </tr>
                            <div class="collapse" id="myCollapse-{{ $order->id }}">
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 mt-4">
                                    @foreach ($order->order_products as $product_item)
                                        <div class="col mb-4">
                                            <div class="card">
                                                <img src="{{ asset('images/products/' . $product_item->product->image) }}"
                                                    alt="Product Image" class="card-img-top" style="height: 200px; max-height: 200px">
                                                <div class="card-body d-flex justify-content-between">
                                                    <h5 class="card-title"><span class="fw-bold me-2">Price:</span>{{ $product_item->product->price }} LE</h5>
                                                    <h5 class="card-title"><span class="fw-bold me-2">Quantity:</span>{{ $product_item->quantity }}</h5>
                                                </div>
                                                <p class="text-primary text-center fs-4">Total Price: <span class="fw-bold">{{ $product_item->product->price * $product_item->quantity }} LE</span></p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
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
                                $totalPrice += $product_item->product->price * $product_item->quantity;
                            }
                        }
                        echo $totalPrice . ' LE';
                        ?>
                    </p>
                </div>

            </div>
            <div class="ms-auto" style="width: fit-content">{{ $orders->links() }}</div>
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
    </div>
@endsection
