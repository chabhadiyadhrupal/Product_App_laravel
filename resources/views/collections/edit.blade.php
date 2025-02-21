@extends('layouts.app')

@section('title', 'Edit Collection')

@section('content')
    <h2>Edit Collection</h2>

    <form action="{{ route('collections.update', $collection->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $collection->title) }}">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Current Image</label><br>
            @if($collection->image)
                <img src="{{ asset('storage/' . $collection->image) }}" width="100"><br>
            @else
                <p class="text-muted">No image available</p>
            @endif
            <label>Upload New Image</label>
            <input type="file" name="image" class="form-control">
            @error('image')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        </div>

        <div class="mb-3">
            <label>Products</label>
            <select name="products[]" multiple class="form-control">
                @foreach($products as $product)
                    <option value="{{ $product->id }}" 
                        @if($collection->products->contains($product->id)) selected @endif>
                        {{ $product->title }}
                    </option>
                @endforeach
            </select>
            @error('products')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        </div>

        <button class="btn btn-primary">Update Collection</button>
        <a href="javascript:history.back()" class="btn btn-secondary">Back</a>

    </form>
@endsection
