@extends('layouts.app')

@section('content')
<h1>All Orders</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            {{-- <th>Order ID</th> --}}
            <th>User-Name</th>
            <th>Product-Title</th>
            <th>Quantity</th>
            <th>Total Price</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            {{-- <td>{{ $order->id }}</td> --}}
            <td>{{ $order->user->name ?? 'Guest' }}</td>
            <td>{{ $order->product->title }}</td>
            <td>{{ $order->quantity }}</td>
            <td>${{ $order->total_price }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="javascript:history.back()" class="btn btn-secondary">Back</a>

@endsection
