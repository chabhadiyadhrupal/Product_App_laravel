<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
  

class productlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('collections')->get();
        return view('productlist.index', compact('products'));
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
      
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    { 
        
        $product = product::findOrFail($id);
        return view('productlist.buy', compact('product'));
    }

    public function addToCart($id)
    {
        $cartItem = Cart::where('product_id', $id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create(['product_id' => $id, 'quantity' => 1]);
        }

        return redirect()->route('cart.show')->with('success', 'Product added to cart!');
    }

    public function showCart()
    {
        $cartItems = Cart::with('product')->get();
        return view('cart.index', compact('cartItems'));
    }
    public function removeFromCart($id)
{
    $cartItem = Cart::where('product_id', $id)->first();

    if ($cartItem) {
       
            $cartItem->delete(); 
        
    }
    return redirect()->route('cart.show')->with('success', 'Product removed from cart!');
}
public function buyNow(Request $request,$id)
    {
        $user = auth();
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);
        $totalAmount = $product->price * $quantity;
    $order = Order::create([
        'user_id' =>$user->id(),
        'product_id' => $product->id,
        'quantity' => $quantity,
        'total_price' => $totalAmount,
    ]);
    // Cart::where('product_id')->where('product_id', $product->id)->delete();
    Cart::where('product_id', $product->id)->delete();
    return view('order.confirm', compact('order', 'product'));
    }

    public function allorders()
    {
        $orders = Order::all();
        return view('order.index', compact('orders'));
    } 
    public function storeOrder(Request $request)
    {
        $orders = Order::where('user_id', auth()->id())->get();

    
        return view('order.index', compact('orders'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
} 