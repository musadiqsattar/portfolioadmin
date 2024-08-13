<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Product;
use Illuminate\Support\Facades\Route;

//Admin Routes
Route::get('/admin',[AdminController::class,'index']);
// Route::get('/adminProducts',[AdminController::class,'products']);
Route::post('/AddNewProduct',[AdminController::class,'AddNewProduct']);
Route::post('/updateProduct',[AdminController::class,'updateProduct']);
Route::get('/itemDelete/{id}',[AdminController::class,'itemDelete']);
Route::get('/viewdesignation',[AdminController::class,'viewdesignation']);
Route::post('/updatedesignation',[AdminController::class,'updatedesignation']);
Route::post('/adddesignation',[AdminController::class,'adddesignation']);
Route::get('/deletedesignation{id}',[AdminController::class,'deletedesignation']);
Route::get('/viewportfolio',[AdminController::class,'viewportfolio']);
Route::post('/insertportfolio',[AdminController::class,'insertportfolio']);
Route::get('/viewabout',[AdminController::class,'viewabout']);
Route::get('/aboutdelete/{id}',[AdminController::class,'aboutdelete']);
Route::get('/hobbiesview',[AdminController::class,'hobbiesview']);
Route::post('/addhobbies',[AdminController::class,'addhobbies']);
Route::get('/viewtechnologies',[AdminController::class,'viewtechnologies']);
Route::post('/inserttechnology',[AdminController::class,'inserttechnology']);
Route::post('/addtechnologiesimg',[AdminController::class,'addtechnologiesimg']);
Route::get('/viewtechnologiesimg',[AdminController::class,'viewtechnologiesimg']);



















//Customer Routes
Route::get('/',[MainController::class,'login']);
Route::get('/cart',[MainController::class,'cart']);
Route::get('/shop',[MainController::class,'shop']);
Route::get('/single/{id}',[MainController::class,'singleProduct']);
Route::get('/checkout',[MainController::class,'checkout']);
Route::get('/register',[MainController::class,'register']);
Route::get('/login',[MainController::class,'login']);
Route::get('/deleteCartItem/{id}',[MainController::class,'deleteCartItem']);

Route::get('/logout',[MainController::class,'logout']);
Route::get('/checkout',[MainController::class,'checkout']);
Route::get('/testMail',[MainController::class,'testMail']);




Route::post('/registerUser',[MainController::class,'registerUser']);
Route::post('/loginUser',[MainController::class,'loginUser']);
Route::post('/addToCart',[MainController::class,'addToCart']);
Route::post('/updateCart',[MainController::class,'updateCart']);