@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <h2>Products</h2>
    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Add Product</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Vendor</th>
                <th>Price</th>
                <th>Collections</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td><img src="{{ asset('storage/' . $product->image) }}" width="50" alt="No Image" ></td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->description }}</td>
                  
                    <td>
                        @foreach($product->variants as $variant)
                            <li>{{ $variant->name }}: {{ $variant->value }} </li>
                        @endforeach
                    </td>
                    <td>${{ $product->price }}</td>
                    
                    <td>@if($product->collections->isEmpty())
                        <span class="text-danger">No Collection</span>
                    @else
                        @foreach($product->collections as $collection)
                            <span class="badge bg-primary">{{ $collection->title }}</span>
                        @endforeach
                    @endif
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn">Edit</a>
                        <form action="{{ route('products.destroy', $product->id)}}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection
