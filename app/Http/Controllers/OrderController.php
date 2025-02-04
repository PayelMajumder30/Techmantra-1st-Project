<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    public function addOrder(){
        $products = Product::all();
        return view('orders.add')->with(['products' => $products]);
    }

    public function storeOrder(Request $request){
        $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|email',
            'phone'         => 'required|string',
            'streetaddress' => 'required|string',
            'pin'           => 'required|string',
            'city'          => 'required|string',
            'product_id'    => 'required|numeric',
            'price'         => 'required|string'
        ]);
        Order::create($request->all());
        return to_route('orders.list')->with('success','Order placed successfully');
    }

    public function listOrder(Request $request){
        // Get the search query from the request
        $search = $request->input('search');
        
        // Fetch orders, filter by name if there's a search query
        $orders = Order::with('product')
                       ->when($search, function($query) use ($search) {
                           return $query->where('name', 'like', '%' . $search . '%');
                       })->orWhere('phone', 'like', '%' . $search . '%')
                       ->orWhere('email', 'like', '%' . $search . '%')
                       ->orWhere('streetaddress', 'like', '%' . $search . '%')
                       ->orWhere('pin', 'like', '%' . $search . '%')
                       ->orWhere('city', 'like', '%' . $search . '%')
                       ->orderby('id', 'DESC')
                       ->simplePaginate(3);
    
        return view('orders.list', compact('orders'));
    }

    public function priceOrder(Request $request){
        $product = Product::find($request->product_id);
        if($product){
            return response()->json(['success' => true, 'price' => $product->price]);
        }else{
            return response()->json(['success' => false, 'message' => 'product not found']);
        }
    }

}
