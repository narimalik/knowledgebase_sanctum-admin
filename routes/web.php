<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
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
    


  

    Route::post('category-save', [CategoryController::class,"store"]);

    Route::get('logout',[UserController::class,'logout']);


}); // end group
