<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class SiteController extends Controller
{
    public function index(Request $request){
        $posts = DB::table("posts as p")->join('users as u', 'p.author', '=', 'u.id')->select("p.*","u.name as name")->orderBy("p.id", "desc")->limit(5)->get();
        return view('site.index',["posts"=>$posts,'site_settings'=>$request->get('site_settings')]);
    }
    public function posts(Request $request){
        $posts = DB::table("posts as p")->join('users as u', 'p.author', '=', 'u.id')->select("p.*","u.name as name")->orderBy("p.id", "desc")->get();
        return view('site.posts', ["posts"=>$posts,'site_settings'=>$request->get('site_settings')]);
    }
    public function postDetails(Request $request,$slug){
        $post = DB::table("posts as p")->join('users as u', 'p.author', '=', 'u.id')->select("p.*","u.name as name")->where("p.slug", $slug)->first();
        return view('site.postDetails', ["post"=>$post,'site_settings'=>$request->get('site_settings')]);
    }
    public function about(Request $request){
        return view('site.about',['site_settings'=>$request->get('site_settings')]);
    }
    public function contact(Request $request){
        return view('site.contact',['site_settings'=>$request->get('site_settings')]);
    }
}
