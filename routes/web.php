<?php

use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LecturerStudentController;
use App\Http\Controllers\StudentController;
use App\Models\LecturerStudent;
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

  // Students Controller
  Route::get('/students/list', [StudentController::class, 'index'])->name('students.list');
  Route::post('/student/create', [StudentController::class, 'store'])->name('students.create');
  Route::post('/student/edit', [StudentController::class, 'update'])->name('students.update');
  Route::post('/student/delete', [StudentController::class, 'destroy'])->name('students.destroy');

  // Lecturers Controller
  Route::get('/lecturers/list', [LecturerController::class, 'index'])->name('lecturers.list');
  Route::post('/lecturer/create', [LecturerController::class, 'store'])->name('lecturers.create');
  Route::post('/lecturer/edit', [LecturerController::class, 'update'])->name('lecturers.update');
  Route::post('/lecturer/delete', [LecturerController::class, 'destroy'])->name('lecturers.destroy');

  // Projects Controller
  Route::get('/projects/list', [LecturerStudentController::class, 'index'])->name('projects.list');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
