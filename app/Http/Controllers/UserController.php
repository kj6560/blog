<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        return view('auth.login',['site_settings'=>$request->get('site_settings')]);
    }
    public function loginAuthentication(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home');
        }
        return redirect()->back()->with('error', 'Invalid Credentials');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function register(Request $request)
    {
        return view('auth.register',['site_settings'=>$request->get('site_settings')]);
    }

    public function createUser(Request $request)
    {
        $data = $request->all();
        if (!empty($data) && $data['email']) {

            $credentials = $request->validate([
                'name' => ['required', 'string'],
                'email' => ['required', 'email']
            ]);

            if ($credentials) {
                $user = User::where("email", $data['email'])->first();
                if (empty($user)) {
                    $password = bcrypt($data['password']);
                    $user = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'email_verified_at' => now(),
                        'password' => $password
                    ]);
                } else {
                    return redirect()->back()->with('error', 'Email already exists. Please login ');
                }

                if ($user) {

                    return redirect()->back()->with('success', 'You have been successfully registered and your password is sent on your registered email id. Please login with the password in the email id.In case you have not recieved email in the inbox, please check your spam or junk folder ');
                } else
                    return back()->withErrors([
                        'email' => 'user already exists.',
                    ])->onlyInput('email');
                if ($user)
                    return redirect("login");
            }
        } else {
            echo "not post";
        }
    }
    public function myprofile(Request $request){
        $user = Auth::user();
        return view('site.myprofile',["user"=>$user,'site_settings'=>$request->get('site_settings')]);
    }
}
