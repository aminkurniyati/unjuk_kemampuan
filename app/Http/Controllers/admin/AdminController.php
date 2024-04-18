<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index() {

        $data['title']  = "PT WES MAKMUR";
        return view('admin.login', $data);

    }

    public function authenticate(Request $request) {

        $validasi   = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if ($validasi->passes()) {
            
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                
                //ADMIN =1 dan EDITOR=2
                $admin = Auth::guard('admin')->user();  

                if ($admin->role == 1) {

                    return redirect()->route('admin.dashboard');

                } else {

                    return redirect()->route('admin.dashboard');
                    
                    // $admin = Auth::guard('admin')->logout();
                    // return redirect()->back()->with('error', 'Hanya admin yg bisa ngakses halaman ini!');
                }

            } else {
                // return redirect()->route('admin.login')->with('error', 'Email/Password Salah!');                
                return redirect()->back()->with('error', 'Email/Password Salah!');               
            }

        } else {
            // return redirect()->route('admin.login')->withErrors($validasi)->withInput($request->only('email'));
            return redirect()->back()->withErrors($validasi)->withInput($request->only('email'));
        }
        

    }
}
