<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
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
   
    public function placeOrder(Request $request){
        $cart = Session::get('cart', []);
        if(empty($cart)){
            return redirect()->route('cart.view')->with('error','Your cart is empty');
        }

        foreach($cart as $product_id => $item){
            Cart::create([
                'name'          => $item['name'],
                'quantity'      => $item['quantity'],
                'price'         => $item['price'],
                'total_price'   => $item['total_price'],
            ]);
        }
        Session::forget('cart'); //remove the 'cart' data from the session after the order has been placed
        return redirect()->route('cart.view')->with('success', 'Your order has been placed successfully!');
    }
    public function showOrder(){
        $carts = Cart::all();
        return view('cart.show', compact('carts'));
    }
    public function deleteCartItem($id){
        $cartItem = Cart::find($id);
        if($cartItem){
            $cartItem->delete();
            return back()->with('success', 'Product removed successfully');
        } else{
            return back()->with('error','Product not found');
        }
    }

}
