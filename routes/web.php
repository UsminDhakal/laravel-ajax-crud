<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/submit/data/ajax', [HomeController::class, 'submit'])->name('submit.form');
Route::get('/get/data/ajax', [HomeController::class, 'getData'])->name('data.get.getData');
Route::get('/get/data/ajax/edit/edit/{id}', [HomeController::class, 'editId'])->name('data.edit.data.data');
Route::get('/get/data/ajax/delete/delete/{id}', [HomeController::class, 'deleteId'])->name('data.delete.data.data');