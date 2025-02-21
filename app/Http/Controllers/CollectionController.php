<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { $collections = Collection::with('products')->get();
        return view('collections.index', compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all(); // Fetch all products
        return view('collections.create', compact('products')); 
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image',
        ]);

        $collection = new Collection($request->all());
        $collection->handle = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $collection->image = $request->file('image')->store('images', 'public');
        }

        $collection->save();
        if ($request->has('products')) {
            $collection->products()->sync($request->products);
        }

        return redirect()->route('collections.index')->with('success', 'Collection added successfully');
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
    public function edit(string $id)
    {
        $collection = Collection::with('products')->findOrFail($id);
        $products = Product::all();

        return view('collections.edit', compact('collection', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'products' => 'nullable|array',
        ]);

        $collection = Collection::findOrFail($id);
        $collection->title = $request->title;
        $collection->handle = Str::slug($request->title);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($collection->image) {
                Storage::delete('public/' . $collection->image);
            }

            // Store new image
            $collection->image = $request->file('image')->store('images', 'public');
        }

        $collection->save();

        if ($request->has('products')) {
            $collection->products()->sync($request->products);
        }

        return redirect()->route('collections.index')->with('success', 'Collection updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        if ($collection->image) {
            Storage::delete('public/' . $collection->image);
        }

        $collection->products()->detach(); // Remove all related products
        $collection->delete();

        return redirect()->route('collections.index')->with('success', 'Collection deleted successfully');
    }
}
