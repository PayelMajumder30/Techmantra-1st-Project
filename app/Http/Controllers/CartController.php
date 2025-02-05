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
        $cart = Session::get('cart', []);
        $orders = Order::all();
        return view('cart.view', compact('cart', 'orders'));
    }

    public function custDetails(Request $request){
        $order = Order::find($request->order_id);
        if ($order) {
            return response()->json([
                'success'       => true,
                'email'         => $order->email,
                'phone'         => $order->phone,
                'streetaddress' => $order->streetaddress,
                'pin'           => $order->pin,
                'city'          => $order->city,
            ]);
        }
        return response()->json(['success' => false]);
    }
   
    public function placeOrder(Request $request){
        $cart = Session::get('cart', []);
        $orders = Order::all();
        if(empty($cart)){
            return redirect()->route('cart.view')->with('error','Your cart is empty');
        }

        $validatedData = $request->validate([
            'order_id'      =>'required|array',
            'email'         =>'required|array',
            'phone'         =>'required|array',
            'streetaddress' =>'required|array',
            'pin'           =>'required|array',
            'city'          =>'required|array',
        ]);
        //dd($validatedData);

        foreach($cart as $product_id => $item){
            // Get the corresponding order_id for this product row
            if(!isset($validatedData['order_id'][$product_id]) || empty($validatedData['order_id'][$product_id])){
                continue;
            };
            $order_id = $validatedData['order_id'][$product_id]?? null;
            // if(!$order_id){
            //     continue;
            // }
            Cart::create([
                'order_id'      => $order_id,
                'email'         => $validatedData['email'][$product_id]??'',             
                'phone'         => $validatedData['phone'][$product_id]??'',
                'streetaddress' => $validatedData['streetaddress'][$product_id]??'',
                'pin'           => $validatedData['pin'][$product_id]??'',
                'city'          => $validatedData['city'][$product_id]??'',
                'name'          => $item['name'],
                'quantity'      => $item['quantity'],
                'price'         => $item['price'],
                'total_price'   => $item['total_price'],
            ]);
            
        }
        dd("insert");
        Session::forget('cart'); //remove the 'cart' data from the session after the order has been placed
        return redirect()->route('cart.showOrder')->with('success', 'Your order has been placed successfully!');
    }
    public function showOrder(){
        $carts = Cart::all();
        return view('cart.show', compact('carts'));
    }
    public function deleteCartItem($id){
       
        $carts = Cart::findOrFail($id);
        $carts -> delete();     
        return redirect()->route('cart.showOrder')->with('success','orders deleted successfully');
    }

}
