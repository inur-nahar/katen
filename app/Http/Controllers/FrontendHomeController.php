<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;
//controller alada aladao toiri kora jay abr ekta controller eo sob kaj kora jay
//{Frontend related sob controller er kaj ekhane eksathe kora hoiche}
class FrontendHomeController extends Controller
//Home Controller
{
    public function index(){
        $featured_posts = post::latest()
        ->where('is_featured', true)
        ->where('status', true)
        ->with(['category:id,name,slug','user:id,name'])
        ->select(['id','user_id','category_id','title','featured_image','created_at'])
        ->take(3)
        ->get();


        $posts = post::latest()
        ->where('status', true)
        ->with(['category:id,name,slug','user:id,name,profile'])
        ->select(['id','user_id','category_id','slug','title','featured_image','short_description','created_at'])
        ->paginate(2);
        return view ('frontend.index',compact('featured_posts','posts'));
    }
//CategoryController
    public function category($slug){
        $posts = post::latest()
        ->where('status', true)
        ->with(['category:id,name,slug','user:id,name,profile'])
        ->wherehas('category', function($query) use ($slug) {
          $query->where('slug',$slug);
        })
        ->orwherehas('subcategory', function($query) use ($slug){
            $query->where('slug',$slug);
          })
        ->select(['id','user_id','category_id','slug','title','featured_image','short_description','created_at'])
        ->paginate(5);


return view('frontend.category', compact('posts'));
    }
    //Single-Page View Controller
    public function showPost($slug){

        $post = post::where('slug',$slug)->first();    //single post tule anar jonno laravel where method use kora hy

        // ->where('status', true)

        // ->wherehas('category', function($query) use ($slug) {
        //   $query->where('slug',$slug);
        // })
        // ->orwherehas('subcategory', function($query) use ($slug){
        //     $query->where('slug',$slug);
        //   })
        // ->select(['id','user_id','category_id','title','featured_image','short_description','created_at'])
        // ->paginate(5);


return view('frontend.post_single', compact('post'));
    }
}
