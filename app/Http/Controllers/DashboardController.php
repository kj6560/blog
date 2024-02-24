<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PageMeta;
use App\Models\Post;
use App\Models\SiteSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

class DashboardController extends Controller
{
    public function _access()
    {
        $user = Auth::user();
        if (intval($user->user_role) != 2) {
            return false;
        } else {
            return true;
        }
    }
    public function index(Request $request)
    {
        if (!$this->_access()) {
            return redirect()->route('myprofile');
        }
        return view('dashboard.index',['site_settings'=>$request->get('site_settings')]);
    }
    public function createCategory(Request $request)
    {
        if (!$this->_access()) {
            return redirect()->route('myprofile');
        }
        $categories = Category::where('parent_id', 0)->orderBy('id', 'desc')->get();
        return view('dashboard.createCategory', ['parent_categories' => $categories,'site_settings'=>$request->get('site_settings')]);
    }
    public function storeCategory(Request $request)
    {
        try {
            if (!$this->_access()) {
                return  redirect('/')->with('error', 'you are not authorized to access this page');
            }
            $data = $request->all();
            if (!empty($data)) {
                $validatedData = $request->validate([
                    'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',

                ]);
                if ($validatedData) {
                    if (!empty($_FILES['image'])) {

                        $upload = $this->uploadFile($_FILES['image'], "category/images");
                        if (empty($upload['errors']) == true) {
                            if (!empty($data['id']) && $data['id'] != null) {
                                $category = Category::find($data['id']);
                            } else {
                                $category = new Category();
                            }
                            $category->name = $data['name'];
                            $category->slug = $this->createSlug($data['name']);
                            $category->status = $data['status'];
                            $category->featured = $data['featured'];
                            $category->popular = $data['popular'];
                            $category->description = $data['description'];
                            $category->parent_id = $data['parent'];
                            $category->image = $upload['file_name'];
                            if ($category->save()) {
                                return redirect()->back()->with('success', 'category created successfully');
                            } else {
                                return redirect()->back()->with('error', 'category creation failed');
                            }
                        } else {
                            return redirect()->back()->with('error', $upload['errors']);
                        }
                    } else {
                        return redirect()->back()->with('error', 'please select icon');
                    }
                }
            } else {
                return redirect()->back()->with('error', 'please fill all fields');
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
    public function editCategory(Request $request, $id)
    {
        if (!$this->_access()) {
            return redirect()->route('myprofile');
        }
        $category = Category::find($id);
        $categories = Category::where('parent_id', 0)->orderBy('id', 'desc')->get();
        return view('dashboard.createCategory', ['category' => $category, 'parent_categories' => $categories,'site_settings'=>$request->get('site_settings')]);
    }
    public function categoryList(Request $request)
    {
        if (!$this->_access()) {
            return redirect()->route('myprofile');
        }
        $categories = Category::orderBy('id', 'desc')->get();
        return view('dashboard.categoryList', ['categories' => $categories,'site_settings'=>$request->get('site_settings')]);
    }
    public function deleteCategory(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $category = Category::find($id);
        if (!empty($id) && Category::destroy($id) && $this->deleteFile($category->image, "category/images")) {
            return redirect()->back()->with('success', 'category deletion successfully');
        } else {
            return redirect()->back()->with('error', 'category deletion failed');
        }
    }
    public function createPost(Request $request)
    {
        if (!$this->_access()) {
            return redirect()->route('myprofile');
        }
        $categories = Category::orderBy('id', 'desc')->get();

        return view('dashboard.createPost', ['categories' => $categories,'site_settings'=>$request->get('site_settings')]);
    }
    public function storePostMedia(Request $request)
    {
        try {
            if (!$this->_access()) {
                return  redirect('/')->with('error', 'you are not authorized to access this page');
            }
            $data = $request->all();
            if (!empty($data)) {
                $validatedData = $request->validate([
                    'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',

                ]);
                if ($validatedData) {
                    if (!empty($_FILES['image'])) {

                        $upload = $this->uploadFile($_FILES['image'], "posts/media");
                        if (empty($upload['errors']) == true) {
                            return response()->json(['status' => 200, 'message' => 'success', 'data' => url("/uploads/posts/media/".$upload['file_name'])]);
                        } else {
                            return response()->json(['status' => 400, 'message' => $upload['errors']]);
                        }
                    }
                }
            }
        } catch (Exception $e) {
        }
    }
    public function storePost(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);

        if (!empty($data['id']) && $data['id'] != null) {
            $post = Post::find($data['id']);
        } else {
            $post = new Post();
        }

        if (!empty($_FILES['header_image']['name'])) {

            $upload = $this->uploadFile($_FILES['header_image'], "posts/media");
            if (!empty($upload['errors']) == true) {
                return response()->json(['status' => 400, 'message' => $upload['errors']]);
            }
        }

        $post->title = $data['title'];
        $post->author = Auth::user()->id;
        $post->sub_title = $data['sub_title'];
        $post->slug = $this->createSlug($data['title']);
        $post->content = $data['content'];
        $post->status = $data['status'];
        $post->category_id = $data['category_id'];
        if(!empty($_FILES['header_image']['name'])){
            $post->header_image = $upload['file_name'];
        }
        if ($post->save()) {
            $pageMeta = new PageMeta();
            $pageMeta->url = "/postDetails/".$post->slug;
            $pageMeta->title = $post->title;
            $pageMeta->description = $data["description"];
            if($pageMeta->save()){
                return redirect()->back()->with('success', 'post created successfully');
            }else{
                return redirect()->back()->with('error', 'post creation failed');
            }
            
        } else {
            return redirect()->back()->with('error', 'post creation failed');
        }
    }
    public function listPost(Request $request)
    {
        if (!$this->_access()) {
            return redirect()->route('myprofile');
        }
        $posts = DB::table("posts as p")->leftJoin('categories as pc', 'p.category_id', '=', 'pc.id')->select("p.id as id", "p.title", "p.slug", "p.status", "p.created_at", "pc.name as category")->orderBy('p.id', 'desc')->get();
        return view('dashboard.listPost', ['posts' => $posts,'site_settings'=>$request->get('site_settings')]);
    }
    public function editPost(Request $request, $id)
    {
        if (!empty($id)) {
            $post = DB::table("posts as p")->leftJoin('page_metas as pm', 'p.title', '=', 'pm.title')->select("p.*","pm.description")->where('p.id',$id)->first();
            $categories = Category::orderBy('id', 'desc')->get();
            return view('dashboard.createPost', ['post' => $post, 'categories' => $categories,'site_settings'=>$request->get('site_settings')]);
        }
    }
    public function deletePost(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        if (!empty($id) && Post::destroy($id)) {
            return redirect()->back()->with('success', 'category deletion successfully');
        } else {
            return redirect()->back()->with('error', 'category deletion failed');
        }
    }
    public function siteSettingsList(Request $request){
        if (!$this->_access()) {
            return redirect()->route('myprofile');
        }
        $site_settings = DB::table("site_settings")->get();
        return view('dashboard.siteSettingsList', ['settings' => $site_settings, 'site_settings'=>$request->get('site_settings')]);
    }
    public function createSiteSettings(Request $request){
        if (!$this->_access()) {
            return redirect()->route('myprofile');
        }
        return view('dashboard.createSiteSettings', ['site_settings'=>$request->get('site_settings')]);
    }
    public function storeSiteSettings(Request $request){
        if (!$this->_access()) {
            return redirect()->route('myprofile');
        }
        $data = $request->all();
        unset($data['_token']);

        if($data['id']){
            $site_setting = SiteSetting::find($data['id']);
        }else{
            $site_setting = new SiteSetting();
        }
        $site_setting->key = $data['key'];
        $site_setting->value = $data['value'];
        $site_setting->status = $data['status'];
        $site_setting->description = $data['description'];
        if($site_setting->save()){
            return redirect()->back()->with('success', 'site settings created successfully');
        }else{
            return redirect()->back()->with('error', 'site settings creation failed');
        }
    }
    public function editSiteSettings(Request $request, $id){
        if(!$this->_access()){
            return redirect()->route('myprofile');
        }
        $site_setting = DB::table("site_settings")->where('id', $id)->first();
        return view('dashboard.createSiteSettings', ['setting'=>$site_setting, 'site_settings'=>$request->get('site_settings')]);
    }
}
 