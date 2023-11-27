<?php

namespace App\Http\Controllers;

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

    // Get the students requests!
    $_requests = Requests::where('student_id', $user->id)->get();

    // dd($user->hasProject);

    return view('dashboard', compact('user', 'lecturers', '_requests'));
  }
}
