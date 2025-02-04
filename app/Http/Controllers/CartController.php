<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    
    public function addToCart(Request $request){
        $product = Product::findOrFail($request->product_id);
        $cart = Session::get('cart',[]);
        $cart[$product->id] = [
            "name"          => $product->name,
            "quantity"      => $request->quantity,
            "price"         => $product->price,
            "total_price"   => $product->price * $request->quantity, 
        ];

        Session::put('cart', $cart);
        return  redirect()->route('cart.view')->with('success', 'Products are added');
    } 

    public function viewCart(){
        $cart = Session::get('cart',[]);
        return view('cart.view', compact('cart'));
    }
}
