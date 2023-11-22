<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
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
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
