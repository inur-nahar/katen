<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
   //create
   public function create(){
    $categories = Category::latest()->get(['id','name']);

    return view('backend.post.create',compact('categories'));
   }
   //index
   public function index(){

$posts = post::with(['user:id,name','category:id,name'])
->latest()
->select(['id','title','user_id','category_id','featured_image','status','is_featured','created_at','updated_at'])
->paginate(10);//Category::all() eta holo Model er ekta method
return view('backend.post.list', compact('posts'));//view te jaoyar somoy categories variable ta sathe kore neoyar jnno compact use hoy
}
   //Post Store
   public function store(Request $request){

    $request->validate([

  "title" => "required|string|max:255",
  "category" => "required|exists:categories,id",
  "subcategory" => "required|exists:subcategories,id",
  "description" => "required|string",
  "short_description" => "required|string|max:255",
  "featured_image" => "required|mimes:jpeg,png,jpg"
  ]);
//slug generator
  $post_slug = str($request->title)->slug();
  $slug_count = post::where('slug','LIKE','%'.$post_slug.'%')->count();
 if($slug_count>0){
  $post_slug .= '-'. $slug_count+1;

 }
 //image/profile image name generator
 if($request->hasFile('featured_image')){
    $featured_image = str()->random(5).time().'.'.$request->featured_image->extension();
    $request->featured_image->storeAs('posts',$featured_image,'public');

    }

$post = new post();
$post->title =$request->title;
$post->slug = $post_slug;
$post->user_id =auth()->id();
$post->category_id =$request->category;
$post->subcategory_id =$request->subcategory;
$post->featured_image =$featured_image;
$post->short_description =$request->short_description;
$post->description =$request->description;
$post->save();
return back();


}
public function change_status(Request $request){
   $post = post::find($request->post_id);
   if($post->status){
    $post->status = false;

   }else{
    $post->status = true;

   }
   $post->save();
}

public function change_feature(Request $request){
    $post = post::find($request->post_feature);
    if($post->featured_image){
     $post->featured_image = false;

    }else{
     $post->featured_image = true;

    }
    $post->save();
 }
 }





