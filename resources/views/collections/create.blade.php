@extends('layouts.app')

@section('title', 'Add Collection')

@section('content')
    <h2>Add Collection</h2>
    <form action="{{ route('collections.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" accept="no image">
            @error('image')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="mb-3">
            <label>Products</label>
            <select name="products[]" multiple class="form-control">
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ in_array($product->id, old('products', [])) ? 'selected' : '' }}>
                        {{ $product->title }}
                    </option>
                @endforeach
            </select>
            <small>Multiple select: Hold Ctrl and click to select multiple</small>
            @error('products')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <button class="btn btn-primary">Save Collection</button>
        <a href="javascript:history.back()" class="btn btn-secondary">Back</a>

    </form>
@endsection
