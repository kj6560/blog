<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index(){
        $posts = DB::table("posts as p")->join('users as u', 'p.author', '=', 'u.id')->select("p.*","u.name as name")->orderBy("p.id", "desc")->limit(5)->get();
        return view('site.index',["posts"=>$posts]);
    }
    public function posts(Request $request){
        $posts = DB::table("posts as p")->join('users as u', 'p.author', '=', 'u.id')->select("p.*","u.name as name")->orderBy("p.id", "desc")->get();
        return view('site.posts', ["posts"=>$posts]);
    }
    public function postDetails($slug){
        $post = DB::table("posts as p")->join('users as u', 'p.author', '=', 'u.id')->select("p.*","u.name as name")->where("p.slug", $slug)->first();
        return view('site.postDetails', ["post"=>$post]);
    }
    public function about(){
        return view('site.about');
    }
    public function contact(){
        return view('site.contact');
    }
}
