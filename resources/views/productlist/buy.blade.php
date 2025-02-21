{{-- @extends('layouts.app')

@section('title', 'buy')

@section('content')
    <h2>buy product</h2>

    <form action="{{ route('productlists.show',$product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $product->title) }}">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

       
        <div class="mb-3">
            <label>Price</label>
            <input type="text" name="price" class="form-control" value="{{ old('price', $product->price) }}  ">
            @error('price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

       
        
        <br>
        <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
    </form>
    <form action="{{ route('order.store', $product->id) }}" method="POST">
        @csrf
        <button class="btn btn-primary">Make Payment</button>
    </form>
    <br><br>
    <form action="{{ route('cart.add', $product->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Add to Cart</button>
    </form>
   
@endsection --}}
