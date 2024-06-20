<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('account/register',[AccountController::class,'register'])
->name('account.register');

Route::post('account/processRegister',[AccountController::class,'processRegister'])
->name('account.processRegister');

Route::get('account/login',[AccountController::class,'login'])
->name('account.login');

Route::post('account/authenticate',[AccountController::class,'authenticate'])
->name('account.authenticate');

Route::get('account/profile',[AccountController::class,'profile'])
->name('account.profile');

Route::get('account/logout',[AccountController::class,'logout'])
->name('account.logout');

Route::post('account/updateProfile',[AccountController::class,'updateProfile'])
->name('account.updateProfile');

Route::get('books/index',[BookController::class,'index'])
->name('books.index');

Route::get('books/create',[BookController::class,'create'])
->name('books.create');

Route::post('books/store',[BookController::class,'store'])
->name('books.store');

Route::get('books/editBook/{id}',[BookController::class,'editBook'])
->name('books.editBook');

Route::post('books/editBook/{id}',[BookController::class,'updateBook'])
->name('books.updateBook');

Route::post('books/deleteBook/',[BookController::class,'deleteBook'])
->name('books.deleteBook');

Route::get('/',[HomeController::class,'index'])
->name('home');

Route::get('/detail/{id}',[HomeController::class,'detail'])
->name('detail');

Route::post('/save-review',[HomeController::class,'saveReview'])
->name('saveReview');