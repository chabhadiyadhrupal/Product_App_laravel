@extends('layouts.app')

@section('title', 'Productslist')

@section('content')
    <h2>Products-list</h2>
   

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td><img src="{{ asset('storage/' . $product->image) }}" width="50" alt="No Image" ></td>
                    <td>{{ $product->title }}</td>
                   
                  
                    
                    <td>${{ $product->price }}</td>
                    
                
                   
                    <td>
                        {{-- <a href="{{ route('order.buy', $product->id) }} " class="btn btn-primary btn">Buy</a> --}}
                       
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" >
                            @csrf
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                         <form action="{{ route('order.buy', $product->id) }}" method="POST" >
                            @csrf
                            <input  type="number" name="quantity" value="1" min="1">
                            <button type="submit" class="btn  btn-success">Buy Now</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection
