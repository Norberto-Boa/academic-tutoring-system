<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::middleware(['auth'])->group(function () {
  Route::get('/students/list', [StudentController::class, 'index'])->name('students.list');
  Route::post('/student/create', [StudentController::class, 'store'])->name('students.create');
  Route::post('/student/edit', [StudentController::class, 'update'])->name('students.update');
  Route::post('/student/delete', [StudentController::class, 'destroy'])->name('students.destroy');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
