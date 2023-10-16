@extends('layouts.userHeader')

@section('content')
<div class="container my-5 ">
   <div class="card">
      <div class="card-body">
          @foreach ($cartItems as $item)

          

          <div class="row">
            <div class="col-md-4">
            <h3>{{ $item->name }}</h3>
            </div>
            <div class="col-md-3">
            <input type="hidden" >
                <label for="Quantity">Quantity</label>
                <div class="input-group text-center mb-3" style="width:130px;">
                    <button class="input-group-text decrement-btn">-</button>
                    <input type="text" name="quantity" class="form-control qty-input text-center" value="1">
                    <button class="input-group-text increment-btn">+</button>
                 </div>
            </div>
            <div class="col-md-3">
                  <h3>{{ $item->price }}</h3>
            </div>
            <div class="col-md-2">
            <form action="{{route('item.destroy',$item->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger">X</button>
            </form>

            </div>
        

          </div>
          @endforeach


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

             <h3 class="my-5">total price</h3>
            <button class="btn btn-success">Confirm</button>
         </div>
          
      </div>

   </div>

</div>



@endsection

