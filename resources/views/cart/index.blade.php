{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2> Cart-list</h2>
    @if($cartItems->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->product->title }}</td>
                    <td>${{ $item->product->price }}</td>
                    <td>{{ $item->quantity }}</td>
                 
                    <td>
                        <form action="{{ route('order.buy', $item->product_id) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="quantity" value="{{ $item->quantity }}">
                            <button type="submit" class="btn btn-success btn-sm">Buy Now</button>
                        </form>
                        <form action="{{ route('cart.remove', $item->product_id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Your cart is empty.</p>
    @endif
    <a href="{{ route('productlists.index') }}" class="btn btn-primary">Continue Shopping</a>
    <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
</div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cart List</h2>

    @if($cartItems->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th> <!-- Added this column -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->product->title }}</td>
                    <td>${{ $item->product->price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ $item->product->price * $item->quantity }}</td> <!-- Calculate Total Price -->
                    <td>
                        <form action="{{ route('order.buy', $item->product_id) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="quantity" value="{{ $item->quantity }}">
                            
                            <button type="submit" class="btn btn-success btn-sm">Buy Now</button>
                        </form>
                        <form action="{{ route('cart.remove', $item->product_id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        

    @else
        <p>Your cart is empty.</p>
    @endif

    <a href="{{ route('productlists.index') }}" class="btn btn-primary">Continue Shopping</a>
    <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
</div>
@endsection
