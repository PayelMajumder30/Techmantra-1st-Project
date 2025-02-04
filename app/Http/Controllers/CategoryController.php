<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;


class CategoryController extends Controller
{
    //
    public function addCategory(){
        return view('categories.add');
    }

    public function storeCategory(Request $request){
        $request->validate([
            'title'    => 'required|string',
            'image'    => 'required|file|mimes:jpg,png,pdf|max:2048',
        ],[
            'title.required'=>'Title field is required',
            'title.image'   =>'Image field is required'
        ]);
        $actual_path = null;
        if($request->has('image')){
            $file = $request->file('image');
            $fileName = time().rand(1000,999).'_'.$file->getClientOriginalExtension();
            $imgPath = public_path("uploads/category",$fileName);
            $file->move($imgPath,$fileName);
            $actual_path = "uploads/category/".$fileName;
        }

        
        $category = Category::create([
            'title'  =>$request->title,
            'image'  =>$actual_path,
        ]);
         if($category){
             //echo "successfully inserted";
             return to_route('categories.list')->with('success','categories added successfully');
         }elseif($category == null){
           // echo "unable to insert";
            return to_route('categories.add')->with('error','Field is required');
         }  
    }

    public function categoryList(){
        $categories = Category::orderby('id', 'DESC')->simplePaginate(2);
       // dd($categories);
        return view('categories.list', compact('categories'));
    }

    public function editCategory($id){
        $category = Category::find($id);  
        return view('categories.update')->with(['category'=>$category]);  
    }

    public function updateCategory(Request $request, $id){
        $request->validate([
            'edtitle'   => 'required|string',
            'edimg'     => 'file|mimes:jpg,png,pdf|max:2048',
        ]);

        if($request->file('edimg')){
            $file       = $request->file('edimg');
            $fileName   = time().rand(1000,999).'_'.$file->getClientOriginalExtension();
            $imgPath    = public_path("uploads/category/". $fileName);
            //dd($imgPath);
            $file->move($imgPath,$fileName);
            $filePath   = "uploads/category/".$fileName;

            if(file_exists(public_path($request->previous_image))){
                unlink(public_path($request->previous_image));
            }
        } else{
            $filePath = $request->previous_image;
        }

        Category::where('id', $id)->update([
            'title' => $request->edtitle,
            'image'   => $filePath,
        ]);

        $category = Category::find($id);

        return to_route('categories.edit', ['id' => $id])->with([
            'category' => $category,
            'success' => 'categories has been updated successfully'
        ]);
    }

    public function destroyCategory($id){
        $category = Category::where('id',$id)->delete();
        if($category){
            return redirect()->route('categories.list')->with('status','category deleted sucessfully');
        }
            return back()->with('error', 'Please provide the valid credentials');   
    }
}
