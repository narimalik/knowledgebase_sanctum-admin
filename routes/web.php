<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Models\Article;
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
    return view('components.homepage');
});


Route::post('/dologin',[ UserController::class , 'login'])->name('dologin');

/*
Route::get ('/register', function(){    return view('components.register');});
Route::post ('/register', [UserController::class, 'register'])->name('register');
*/

 Route::get ('/login', function(){
     return view('components.login');
 })->name('login');



Route::middleware(['auth'])->group(function(){

    Route::get('dashboard', function(){        
        return view('components.dashboard');
    })->name('dashboard');


    Route::get('add-category',[CategoryController::class,"create"])->name("add-category");



    // Route::get('category', function(){        
    //     return view('components.category');
    // })->name('category');

    Route::get('category', [CategoryController::class,'index'])->name("category");

    Route::get('category/edit/{id}', [CategoryController::class,'edit']);
    Route::post('category-update', [CategoryController::class,"update"])->name("category-update");
    
    Route::get('category/delete/{id}', [CategoryController::class,'destroy']);

    Route::post('category-save', [CategoryController::class,"store"]);

    Route::get('category/articles/{id}', [CategoryController::class,'show']);


    #Articles
    Route::get('articles', [ArticleController::class,'index'])->name("article");
    Route::get('add-article',[ArticleController::class,"create"])->name("add-article");
    Route::post('article-save', [ArticleController::class,"store"]);    

    Route::get('article/edit/{id}', [ArticleController::class,'edit'])->name("edit-article");

    Route::post('article-update', [ArticleController::class,"update"]);  

    Route::get('article/delete/{id}', [ArticleController::class,'destroy']);

    //Upload image for editor
    Route::post('upload', [ArticleController::class,'upload'])->name('upload');


    //Create new User

    Route::get("userregisteration", [UserController::class, 'showRegisteration'])->name('userregisteration');
    Route::post("adduser", [UserController::class, "register"])->name("adduser");

    Route::get("usersList", [UserController::class, 'usersList'])->name('usersList');

    Route::get("user/edit/{id}", [UserController::class, 'editUser'])->name('editUser');

    Route::get("user/gettoken/{id}", [UserController::class, 'gettoken'])->name('gettoken');

    Route::post('user-update', [UserController::class,"userupdate"]);  

    
    Route::get('user/delete/{id}', [UserController::class,'destroy']);    

    Route::get('logout',[UserController::class,'logout']);


}); // end group
