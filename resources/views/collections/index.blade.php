@extends('layouts.app')

@section('title', 'Collections')

@section('content')
    <h2>Collections</h2>
    <a href="{{ route('collections.create') }}" class="btn btn-success mb-3">Add Collection</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Products</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($collections as $collection)
                <tr>
                    <td><img src="{{ asset('storage/' . $collection->image) }}" width="50" alt="No Image" ></td>
                    <td>{{ $collection->title }}</td>
                    <td>
                        @if($collection->products->isEmpty())
        <span class="text-danger">No Products</span>
    @else
        @foreach($collection->products as $product)
            <span class="badge bg-primary">{{ $product->title }}</span>
        @endforeach
    @endif
                    </td>
                    <td>
                        <a href="{{ route('collections.edit', $collection->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('collections.destroy', $collection->id) }}" method="POST" style="display:inline;">
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
