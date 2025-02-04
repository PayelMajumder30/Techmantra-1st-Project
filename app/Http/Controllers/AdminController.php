<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\Support\Facades\Auth;
use App\Models\User;    


class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function showLogin(){
        return view('admin.login');
    }

    public function submitLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([    
            'email' => 'required',
            'password' => 'required',
        ]);
        // dd($credentials);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
           return redirect()->route('admin.dashboard')->with('status','user login successfully');
        }

        return back()->with('error','Please Provide the valid credentials');

        // $user = User::where('email', $request->email)->first();
        // // dd($user);
        // if ($user && Hash::check($request->password, $user->password)) {
        //     //echo "login successfully done";
        //     return redirect()->route('products.list')->with('status','user login successfully');
        // }else{
        //    // echo "unable to login";
        //     return redirect()->route('admin.login')->with('error','Please Provide the valid credentials');
            
        // }
           
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'You\'ve sucessfully logged out');
    }
    
}
