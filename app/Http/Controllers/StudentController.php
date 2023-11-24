<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $students = User::role('student')->get();

    return view('students.list', compact('students'));
  }

  /**
   * Store a newly created resource in storage.
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    try {
      $request->validate([
        'name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:50'],
        'phone_number' => ['required', 'numeric'],
      ]);
    } catch (\Throwable $th) {
      throw $th;
    }


    $data = $request->all();
    $password = "Student123";

    $student = new User();

    $student->name = $data['name'];
    $student->email = $data['email'];
    $student->phone_number = $data['phone_number'];
    $student->password = $password;
    $student->save();

    $student->assignRole('student');

    return redirect()->back()->with('success', 'The student has been successfully created. With the name ' . $student->name);
  }

  /**
   * Update the specified resource in storage.
   * @param \Illuminate\Http\Request $request
   * @param \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'id' => ['required', 'integer'],
        'name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:50'],
        'phone_number' => ['required', 'numeric'],
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }
    } catch (\Throwable $th) {
      throw $th;
    }

    $data = $request->all();
    $student = User::find($data['id']);

    if ($student->hasRole('student')) {
      $student->name = $data['name'];
      $student->email = $data['email'];
      $student->phone_number = $data['phone_number'];

      $student->update();
      return redirect()->back()->with('success', 'Student information updated successfully!');
    }

    return redirect()->back()->with('warning', 'Something went wrong with your request!');
  }

  /**
   * Remove the specified resource from storage.
   * @param \Illuminate\Http\Request $request
   * @param \Illuminate\Http\RedirectResponse
   */
  public function destroy(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'student_id' => ['required', 'integer']
      ]);

      if ($validator->fails()) {
        return redirect()->back()->with('error', 'Something went wrong with your request!');
      }
    } catch (\Throwable $th) {
      throw $th;
    }

    $data = $request->all();

    $student = User::Find($data['student_id']);

    if ($student->hasRole('student')) {
      $student->delete();
      return redirect()->back()->with('deleted', 'Student ' . $student->name . 'was deleted successfully!');
    }

    return redirect()->back()->with('warning', 'Something went wrong with your request!');
  }
}
