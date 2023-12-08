<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   //index page(Listing Page)
public function index(){
    // $categories = Category::with('subcategories')->get();

    //database theke data tule anar jonno
    $categories = Category::paginate(5);//Category::all() eta holo Model er ekta method
return view('backend.category.list', compact('categories'));//view te jaoyar somoy categories variable ta sathe kore neoyar jnno compact use hoy
}


//store  page(Store new data)
public function store(Request $request){
$request->validate([
    'name'=> 'required|string|max:255'
    ]);
    $category_slug = str($request->name)->slug();
    $slug_count = Category::where('slug','LIKE','%'.$category_slug.'%')->count();
   if($slug_count>0){
    $category_slug .= '-'. $slug_count+1;

   }

    $category = new Category();
    $category->name =$request->name;
    $category->slug = $category_slug;
    $category->save();
    return back();

}


//view  page(view single data)
// public function view($id){
//     return view('backend.category.view');
// }
//edit  page(edit form)
public function edit($id){
    $categories = Category::paginate(5);
    $editdata = Category::findOrFail($id, ['id','name']);
    return view('backend.category.list', compact('categories','editdata'));

}

//update  page(update single data)
public function update(Request $request, $id){
    $request->validate([
        'name'=> 'required|string|max:255'
        ]);
        $category_slug = str($request->name)->slug();
        $slug_count = Category::where('slug','LIKE','%'.$category_slug.'%')->count();
       if($slug_count>0){
        $category_slug .= '-'. $slug_count+1;

       }

       $category = Category::find($id);
        $category->name =$request->name;
        $category->slug = $category_slug;
        $category->save();
        return back();
}
//delete page(update single data)
public function delete($id){
$category_count = Category::count();
if($category_count > 1){
$category = Category::find($id);
$category->delete();
return back();
}
return back();
}

}
