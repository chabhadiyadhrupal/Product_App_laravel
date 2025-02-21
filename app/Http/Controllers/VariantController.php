<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variant;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        Variant::create($request->all());

        return back()->with('success', 'Variant added successfully!');
    
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
        return view('variants.edit', compact('variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Variant $variant)
    {
        $request->validate([
            'name' => 'required|string',
            'value' => 'required|string',
           
        ]);

        $variant->update($request->all());

        return redirect()->route('variants.index')->with('success', 'Variant updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $variant = Variant::findOrFail($id);
    $variant->delete();
    return back()->with('success', 'Variant deleted successfully!');
}

}
