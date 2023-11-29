<?php

namespace App\Http\Controllers;

use App\Models\LecturerStudent;
use App\Models\Requests;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $user = Auth::user();
    $lecturers = User::role('lecturer')->get();
    $students = User::role('student')->get();
    $_requests = Requests::all();
    $projects = LecturerStudent::all();

    // dd($user->hasProject);

    return view('dashboard', compact('lecturers', '_requests', 'students', 'projects'));
  }
}
