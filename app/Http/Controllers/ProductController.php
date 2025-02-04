<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

use function Laravel\Prompts\search;


class ProductController extends Controller
{
    public function productList(){
        // dd(Auth::id());
        $products = Product::orderby('id', 'DESC')->get();
        // dd($products);
        return view('products.list', compact('products'));
    }

    public function addProduct(){
        
        $categories = Category::all();
        return view('products.add',compact('categories'));
    }

    public function storeProduct(Request $request){
        // dd($request->all());
        $request->validate([
            'name'          => 'required|string',
            'quantity'      => 'required|integer',
            'price'         => 'required|numeric',
            'image'         => 'required|file|mimes:jpg,png,pdf|max:2048',
            'category_id'   => 'required'
        ]);
       //dd($request->all());
        // Check for move the images
       if($request->image){
         $file = $request->file('image');
         $fileName = time().rand(1000,9999).'-'.$file->getClientOriginalExtension();
         $imgPath = public_path("uploads/product",$fileName);
         $file->move($imgPath,$fileName);
       }

        Product::create([
            'name'       =>$request->name,
            'quantity'   =>$request->quantity,
            'price'      =>$request->price,
            'image'      => "uploads/product/".$fileName,
            'category_id'   =>$request->category_id,
        ]);

        return to_route('products.list')->with('success','Product added successfully');


    }
    public function index(Request $request)
    {
        // Get the search term from the request
        $search = $request->input('name');

        // Query products, filter by name if search term is provided
        $products = Product::when($search, function($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->get();

        // Return the view with the filtered products
        return view('products.list', compact('products'));
    }


    public function editProduct($id){
        $product = Product::find($id);
        $categories = Category::all();
        return view('products.update')->with(['product'=>$product, 'categories'=>$categories]);
    }

    public function updateProduct(Request $request, $id){
        $request->validate([
            'editname'      => 'required|string',
            'editquantity'  => 'required|integer',
            'editprice'     => 'required|numeric',
            'category_id'   => 'required|numeric',
            'editimage'     => 'file|mimes:jpg,png,pdf|max:2048',
        ]);
          //dd($request->all());
              // File upload if exist
              if ($request->file('editimage')) {
                $file       = $request->file('editimage');
                $fileName   = time().rand(1000,9999).'-'.$file->getClientOriginalExtension();
                $imgPath    = public_path("uploads/product", $fileName);
                $file->move($imgPath,$fileName);
                $filePath   = "uploads/product/".$fileName;

                // Unlink previously saved image from file system if exist
                if (file_exists(public_path($request->previous_image))) {
                    unlink(public_path($request->previous_image));
                }
            } else {
                $filePath = $request->previous_image;
            }

        // option 1
        // $product = Product::find($id); // Select query

        // if($product){
        //     $product ->name     = $request->editname;
        //     $product ->quantity = $request->editquantity;
        //     $product ->price    = $request->editprice;
        //     $product ->image    = $request->editimage;
        //     $product ->save(); // upate query
        // }

        // option 2
        Product::where('id', $id)->update([
            'name'       => $request->editname,
            'quantity'   => $request->editquantity,
            'price'      => $request->editprice,
            'category_id'=> $request->category_id,
            'image'      => $filePath,
        ]);
        $product = Product::find($id);

        return to_route('products.edit', ['id' => $id])->with([
            'product' => $product,
            'success' => 'Product details has been updated successfully'
        ]);
    }
    public function destroyProduct($id){
        $product  = Product::where('id',$id)->delete();
        if($product){
            return redirect()->route('products.list')->with('status','Product deleted successfully');
        }
        return back()->with('error','Please Provide the valid credentials');
    }

  
}
