@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
    <h2>Add Product</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <h4>Variants</h4>
        <div id="variants">
            @php $variantCount = old('variants') ? count(old('variants')) : 1; @endphp
            
            @for ($i = 0; $i < $variantCount; $i++)
                <div class="variant">
                    <input type="text" name="variants[{{ $i }}][name]" placeholder="Variant Name" class="form-control mb-2" value="{{ old("variants.$i.name") }}" required>
                    @error("variants.$i.name") <span class="text-danger">{{ $message }}</span> @enderror

                    <input type="text" name="variants[{{ $i }}][value]" placeholder="Variant Value" class="form-control mb-2" value="{{ old("variants.$i.value") }}" required>
                    @error("variants.$i.value") <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            @endfor
        </div>

        <button type="button" id="addVariant" class="btn btn-secondary">Add Variant</button>
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="text" name="price" class="form-control" value="{{ old('price') }}" required>
            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

       
        <div class="mb-3">
            <label>Collections</label>
            <select name="collections[]" multiple class="form-control">
                @foreach($collections as $collection)
                    <option value="{{ $collection->id }}" 
                        {{ (collect(old('collections'))->contains($collection->id)) ? 'selected' : '' }}>
                        {{ $collection->title }}
                    </option>
                @endforeach
            </select>
            <small>Multiple select: Hold CTRL and click</small>
            @error('collections') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button class="btn btn-primary">Save Product</button>
        <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
    </form>
    <script>
        let variantCount = 1;
        document.getElementById('addVariant').addEventListener('click', function() {
            let variantHtml = `
                <div class="variant">
                    <input type="text" name="variants[${variantCount}][name]" placeholder="Variant Name" class="form-control mb-2">
                    <input type="text" name="variants[${variantCount}][value]" placeholder="Variant Value" class="form-control mb-2">
                </div>
            `;
            document.getElementById('variants').insertAdjacentHTML('beforeend', variantHtml);
            variantCount++;
        });
    </script>
@endsection
