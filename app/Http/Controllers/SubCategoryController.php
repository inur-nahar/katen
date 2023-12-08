<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    //index page(Listing Page)
public function index(){
    //database theke data tule anar jonno
    $subcategories = Subcategory::with('category')->latest()->paginate(5);
    $categories = Category::latest()->select('id','name')->get();
return view('backend.category.subCategory_list',compact('categories','subcategories'));
}
//STORE1
public function store(Request $request){
    $request->validate([
        'name'=> 'required|string|max:255',
        'category'=> 'required|exists:categories,id',
        ]);
        $category_slug = str($request->name)->slug();
        $slug_count = Subcategory::where('slug','LIKE','%'.$category_slug.'%')->count();
       if($slug_count>0){
        $category_slug .= '-'. $slug_count+1;

       }

        $category = new Subcategory();
        $category->name =$request->name;
        $category->category_id = $request->category;
        $category->slug = $category_slug;
        $category->save();
        return back();

    }
    public function getSubcategory(Request $request){

        $subcategories = Subcategory::where('category_id', $request->category )->latest()->get(['id','name']);
        return $subcategories ;
    }

    //edit  page(edit form)
public function edit($id){
    $subcategories = Subcategory::paginate(5);
    $editdata = Subcategory::findOrFail($id, ['id','name']);
    return view('backend.category.subCategory_list', compact('subcategories','editdata'));

}

    //update  page(update single data)
public function update(Request $request, $id){
    $request->validate([
        'name'=> 'required|string|max:255'
        ]);
        $subcategory_slug = str($request->name)->slug();
        $slug_count = Subcategory::where('slug','LIKE','%'.$subcategory_slug.'%')->count();
       if($slug_count>0){
        $subcategory_slug .= '-'. $slug_count+1;

       }

       $subcategory = Subcategory::find($id);
       $subcategory->name =$request->name;
       $subcategory->slug = $subcategory_slug;
       $subcategory->save();
        return back();
}

    //delete page(update single data)
public function delete($id){
    $subcategory_count = Subcategory::count();
    if($subcategory_count > 1){
    $category = Subcategory::find($id);
    $category->delete();
    return back();
    }
    return back();
    }

}
