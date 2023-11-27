<?php

namespace App\Http\Controllers;

use App\Models\LecturerStudent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LecturerStudentController extends Controller
{
  /**
   * Display a listing of the resource.
   * @param \Illuminate\Http\Response
   */
  public function index()
  {
    $projects = LecturerStudent::all();
    $students = User::role('student')->get();
    $lecturers = User::role('lecturer')->get();
    dd(Auth::user()->isTutoring);

    return response(view('projects.list', compact('projects', 'lecturers', 'students')));
  }


  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(LecturerStudent $lecturerStudent)
  {
    //
  }
}
