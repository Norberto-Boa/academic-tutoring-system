<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\User;
use App\Notifications\StudentRequestToAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class RequestsController extends Controller
{
  /**
   * Display a listing of the resource.
   */

  public function index()
  {
    $_requests = Requests::all();

    return response(view());
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
   * @param \Illuminate\Http\Request $request
   * @param \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'topic' => ['string', 'required'],
        'lecturer_id' => ['integer', 'required'],
        'description' => ['string', 'required'],
        'proposal' => ['required', 'mimes:pdf']
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }
    } catch (\Throwable $th) {
      throw $th;
    }

    $data = $request->all();
    $user = $request->user();

    if (!$user->hasProject->isEmpty()) {
      return redirect()->back()->with('warning', 'You cannot make a request while developing another project!');
    }

    $proposal_url = $request->file('proposal')->store('proposals', 'public');
    $_request = new Requests();
    $_request->topic = $data['topic'];
    $_request->lecturer_id = $data['lecturer_id'];
    $_request->student_id = $user->id;
    $_request->admin_approval = "pending";
    $_request->lecturer_approval = "pending";
    $_request->description = $data['description'];
    $_request->proposal_url = base64_encode($proposal_url);
    $saved = $_request->save();

    if ($saved) {
      $admin = User::role('admin')->pluck('email');
      $lecturers = User::where('id', $_request->lecturer_id)->pluck('email');
      $ccRecepients = $lecturers->merge($admin);

      Notification::route('mail', $user->email)->notify(new StudentRequestToAdmin(
        $user,
        1,
        $ccRecepients
      ));
      return redirect()->back()->with('success', 'Your proposal was successfully submitted.');
    }

    return redirect()->back()->with('error', 'Something went wrong kid!');
  }

  /**
   * Display the specified resource.
   */
  public function showByRequestId(int $requestid)
  {
    $_request = Requests::find($requestid);

    if (!$_request) {
      return redirect()->route('dashboard')->with('warning', 'No request found');
    } else {
      $student = User::where('studentid', $_request->student_id)->get();
      $lecturer = User::where('lecturerid', $_request->lecturer_id)->get();

      dd($student);
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Requests $requests)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Requests $requests)
  {
    //
  }
}
