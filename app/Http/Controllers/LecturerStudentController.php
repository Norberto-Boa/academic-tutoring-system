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

    return response(view('projects.list', compact('projects', 'lecturers', 'students')));
  }


  /**
   * Show a single project
   * @param integer $id
   * @param \Illuminate\Http\Response
   */
  public function show(int $id)
  {
    $project = LecturerStudent::find($id);

    return response(view('projects.single', compact('project')));
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
