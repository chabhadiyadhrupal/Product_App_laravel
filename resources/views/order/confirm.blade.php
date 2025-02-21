@extends('layouts.app')

@section('content')
<h1>Confirm Order</h1>
<p>Product: {{ $product->title }}</p>
<p>Amount: ${{ $product->price }}</p>

<form action="{{ route('order.store') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="quantity" value="1"> 
    <input type="hidden" name="total_price" value="{{ $product->price }}"> 
    <button type="submit">Order Confirm</button>
    <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
</form>
@endsection
