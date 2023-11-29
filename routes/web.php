<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LecturerStudentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestsController;
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

  Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

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
  Route::get('/project/{id}', [LecturerStudentController::class, 'show'])->name('projects.show');

  //Request Controller
  Route::get('/request', [RequestsController::class, 'index'])->name('request.list');
  Route::post('/request/store', [RequestsController::class, 'store'])->name('request.store');
  Route::get('/request/{id}', [RequestsController::class, 'showByRequestId'])->name('request.showByRequestId');
  Route::post('/request/update', [RequestsController::class, 'update'])->name('request.update');
  Route::post('/request/feedback', [RequestsController::class, 'adminApproval'])->name('request.feedback');
  Route::post('/request/lecturer/feedback', [RequestsController::class, 'lecturerFeedback'])->name('request.lecturer.feedback');

  // Post Controller
  Route::post('/post/create', [PostController::class, 'store'])->name('post.store');
  Route::post('/post/delete', [PostController::class, 'destroy'])->name('post.destroy');
  Route::post('/post/update', [PostController::class, 'update'])->name('post.update');
  Route::get('post/{id}', [PostController::class, 'show'])->name('post.show');

  // Comment Controller
  Route::post('/comment/create', [CommentController::class, 'store'])->name('comment.store');

  // Profile Controller
  Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});

Auth::routes();
