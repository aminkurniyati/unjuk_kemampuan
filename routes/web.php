<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ArticleController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function(){

    Route::group(['middleware' => 'admin.guest'], function(){

        Route::get('/login', [AdminController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');

    });

    Route::group(['middleware' => 'admin.auth'], function(){

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [DashboardController::class, 'logout'])->name('admin.logout');

        // route Category
        Route::resource('/category', CategoryController::class);

        // Route Products
        Route::resource('/product', ProductController::class);

        //Route user
        Route::resource('/user', UserController::class);

        // GET|HEAD        admin/user ................. user.index › admin\ProductController@index
        // POST            admin/user ................. user.store › admin\ProductController@store  
        // GET|HEAD        admin/user/create ........ user.create › admin\ProductController@create
        // GET|HEAD        admin/user/{user} .........user.show › admin\ProductController@show  
        // PUT|PATCH       admin/user/{user} ........ user.update › admin\ProductController@update  
        // DELETE          admin/user/{user} ........ user.destroy › admin\ProductController@destroy  
        // GET|HEAD        admin/user/{user}/edit ... user.edit › admin\ProductController@edit 

        // Artikel
        Route::resource('/article', ArticleController::class);
        // GET|HEAD        admin/article ................. article.index › admin\ProductController@index
        // POST            admin/article ................. article.store › admin\ProductController@store  
        // GET|HEAD        admin/article/create ........   article.create › admin\ProductController@create
        // GET|HEAD        admin/article/{article} ........article.show › admin\ProductController@show  
        // PUT|PATCH       admin/article/{article} ........article.update › admin\ProductController@update  
        // DELETE          admin/article/{article} ......  article.destroy › admin\ProductController@destroy  
        // GET|HEAD        admin/article/{article}/edit ...article.edit › admin\ProductController@edit

    });

});