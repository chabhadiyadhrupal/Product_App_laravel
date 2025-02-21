<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Variant;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('collections')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $collections = Collection::all();
        return view('products.create', compact('collections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'vendor' => 'nullable|string|max:255',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'collections' => 'nullable|array',
        'variants.*.name' => 'required|string',
            'variants.*.value' => 'required|string',
    ]);

    $product = new Product($request->all());
    $product->handle = Str::slug($request->title);

    if ($request->hasFile('image')) {
        $product->image = $request->file('image')->store('images', 'public');
    }

    $product->save();
    $product->collections()->attach($request->collections);
foreach ($request->variants as $variant) {
            $product->variants()->create($variant);
        }
    return redirect()->route('products.index')->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $product = Product::findOrFail($id);
    $collections = Collection::all(); // Get all collections
    return view('products.edit', compact('product', 'collections'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'veriant' => 'nullable|string|max:255',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'collections' => 'nullable|array', 
        'variants.*.id' => 'nullable|exists:variants,id',
        'variants.*.name' => 'required|string',
        'variants.*.value' => 'required|string'
    ]);

    $product = Product::findOrFail($id);

    // Update product details
    $product->title = $validated['title'];
    $product->description = $validated['description'] ?? null;
    $product->vendor = $validated['vendor'] ?? null;
    $product->price = $validated['price'];
    $product->handle = Str::slug($validated['title']);

    // Handle Image Upload
    if ($request->hasFile('image')) {
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
    }

    $product->save();

    // Sync collections
    if ($request->collections) {
        $product->collections()->sync($request->collections);
    }

    if ($request->has('variants')) {
        $variantIds = [];

        foreach ($request->variants as $variantData) {
            if (!empty($variantData['id'])) {
                // Update existing variant
                $variant = $product->variants()->find($variantData['id']);
                if ($variant) {
                    $variant->update([
                        'name' => $variantData['name'],
                        'value' => $variantData['value'],
                       
                    ]);
                }
                $variantIds[] = $variantData['id'];
            } else {
                // Create new variant
                $newVariant = $product->variants()->create([
                    'name' => $variantData['name'],
                    'value' => $variantData['value'],
                    
                ]);
                $variantIds[] = $newVariant->id;
            }
        }

        // Delete removed variants
        $product->variants()->whereNotIn('id', $variantIds)->delete();
    }

    return redirect()->route('products.index')->with('success', 'Product updated successfully');
}

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
