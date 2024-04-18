<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request) {
        // $data = $request->session()->only(['username', 'email']);
        // dd($data);
        $data['title']      = "PT WES MAKMUR";
        $data['produk']     = Product::count();
        $data['category']   = Category::count();
        $data['users']      = User::count();
        $data['article']    = Article::count();
        return view('admin.dashboard', $data);

    }

    public function logout() {

        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
