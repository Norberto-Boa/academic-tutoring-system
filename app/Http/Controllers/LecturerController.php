<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LecturerController extends Controller
{
  /**
   * Display a listing of the resource.
   * @param \Illuminate\Http\Response
   */
  public function index()
  {
    $lecturers = User::role('lecturer')->get();

    return response(view('lecturer.list', compact('lecturers')));
  }

  /**
   * Store a newly created resource in storage.
   * @param \Illuminate\Http\Request $request
   * @param \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:50'],
        'phone_number' => ['required', 'numeric']
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }
    } catch (\Throwable $th) {
      throw $th;
    }

    $data = $request->all();
    $password = 'Lecturer123';

    $lecturer = new User();

    $lecturer->name = $data['name'];
    $lecturer->email = $data['email'];
    $lecturer->phone_number = '+258' . $data['phone_number'];
    $lecturer->password = $password;
    $lecturer->save();
    $lecturer->assignRole('lecturer');

    return redirect()->back()->with('success', 'The lecturer was sucessfully registered. With name ' . $lecturer->name);
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
        'phone_number' => ['required', 'numeric']
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }
    } catch (\Throwable $th) {
      throw $th;
    }

    $data = $request->all();
    $lecturer = User::find($data['id']);

    if ($lecturer->hasRole('lecturer')) {
      $lecturer->name = $data['name'];
      $lecturer->email = $data['email'];
      $lecturer->phone_number = $data['phone_number'];

      $lecturer->update();
      return redirect()->back()->with('success', 'Lecturer information updated successfully!');
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
        'id' => ['required', 'integer']
      ]);

      if ($validator->fails()) {
        return redirect()->back()->with('warning', 'Your request has an Invalid ID!');
      }
    } catch (\Throwable $th) {
      throw $th;
    }

    $data = $request->all();

    $lecturer = User::find($data['id']);

    if ($lecturer->hasRole('lecturer')) {
      $lecturer->delete();
      return redirect()->back()->with('deleted', 'Successfully deleted ' . $lecturer->name . ' from lecturers list!');
    }

    return redirect()->back()->with('warning', 'Sorry something went wrong with your request!');
  }
}
