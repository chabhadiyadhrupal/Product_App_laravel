@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
    <h2>Edit Product</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $product->title) }}">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="mb-3">
            <label>Price</label>
            <input type="text" name="price" class="form-control" value="{{ old('price', $product->price) }}">
            @error('price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            <br>
            <img src="{{ asset('storage/' . $product->image) }}" width="100">
            @error('image')
            <small class="text-danger">{{ $message }}</small>
        @enderror

        </div>
       
        <div id="variant-container"> 
            @foreach($product->variants as $index => $variant)
                <div class="variant">
                    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                    <input type="text" name="variants[{{ $index }}][name]" value="{{ old("variants.$index.name", $variant->name) }}" required>
            @error("variants.$index.name")
                <small class="text-danger">{{ $message }}</small>
            @enderror
                    <input type="text" name="variants[{{ $index }}][value]"  value="{{ old("variants.$index.value", $variant->value) }}" required>
                    @error("variants.$index.value")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <button type="button" class="remove-variant">Remove</button>
                </div>
            @endforeach
        </div>
    
        <button type="button" id="add-variant">Add Variant</button>
    
        <div class="mb-3">
            <label>Collections</label>
            <select name="collections[]" multiple class="form-control">
                @foreach($collections as $collection)
                    <option value="{{ $collection->id }}" 
                        @if(in_array($collection->id, $product->collections->pluck('id')->toArray())) selected @endif>
                        {{ $collection->title }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <button class="btn btn-primary">Update Product</button>
        <a href="javascript:history.back()" class="btn btn-secondary">Back</a>

    </form>
   
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let variantCount = {{ $product->variants->count() }};
            
            document.getElementById("add-variant").addEventListener("click", function () {
                let container = document.getElementById("variant-container");
                let newVariant = `
                    <div class="variant">
                        <input type="hidden" name="variants[${variantCount}][id]" value="">
                        <input type="text" name="variants[${variantCount}][name]" placeholder="Variant Name" required>
                        <input type="text" name="variants[${variantCount}][value]" placeholder="Variant Value" required>
                       
                        <button type="button" class="remove-variant">Remove</button>
                    </div>`;
                container.insertAdjacentHTML("beforeend", newVariant);
                variantCount++;
            });
        
            document.getElementById("variant-container").addEventListener("click", function (e) {
                if (e.target.classList.contains("remove-variant")) {
                    e.target.parentElement.remove();
                }
            });
        });
        </script>
@endsection