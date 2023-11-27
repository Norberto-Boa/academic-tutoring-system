<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\User;
use App\Notifications\StudentRequestToAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class RequestsController extends Controller
{
  /**
   * Display a listing of the resource.
   */

  public function index()
  {
    $_requests = Requests::all();

    return response(view('proposals.list', compact('_requests')));
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
        $ccRecepients,
        "Submission"
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
      $student = User::Find($_request->student_id);
      $lecturer = User::Find($_request->lecturer_id);
      // dd($lecturer);

      return response(view('proposals.single', compact('_request', 'lecturer', 'student')));
    }
  }

  /**
   * Update the specified resource according to the admin approval choice
   * @param Request $request
   * @param \Illuminate\Http\RedirectResponse
   */
  public function adminApproval(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'id' => ['required', 'integer'],
        "feedback" => ['required', 'string']
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }
    } catch (\Throwable $th) {
      throw $th;
    }

    $id = $request->id;
    $feedback = $request->feedback;
    $_request = Requests::find($id);
    if ($feedback == "accepted") {
      $_request->admin_approval = 'accepted';
      $_request->update();
      return redirect()->back()->with('success', 'You have answered the request from the student!');
    } else if ($feedback == "rejected") {
      $_request->admin_approval = 'rejected';
      $_request->update();
      return redirect()->back()->with('success', 'You have answered the request from the student!');
    } else if ($feedback == "pending") {
      $_request->admin_approval = 'pending';
      $_request->update();
      return redirect()->back()->with('success', 'You have answered the request from the student!');
    }

    return redirect()->back()->with('warning', 'Something went wrong with your feedback.');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'id' => ['integer', 'required'],
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
    $_request = Requests::Find($data['id']);
    if ($user->id !== $_request->student_id) {
      return redirect()->back()->with('warning', 'Never try to fools!');
    }
    $_request->topic = $data['topic'];
    $_request->lecturer_id = $data['lecturer_id'];
    $_request->student_id = $user->id;
    $_request->admin_approval = "pending";
    $_request->lecturer_approval = "pending";
    $_request->description = $data['description'];
    $_request->proposal_url = base64_encode($proposal_url);
    $saved = $_request->update();

    if ($saved) {
      $admin = User::role('admin')->pluck('email');
      $lecturers = User::where('id', $_request->lecturer_id)->pluck('email');
      $ccRecepients = $lecturers->merge($admin);

      Notification::route('mail', $user->email)->notify(new StudentRequestToAdmin(
        $user,
        1,
        $ccRecepients,
        "update"
      ));
      return redirect()->back()->with('success', 'Your proposal was successfully edited.');
    }

    return redirect()->back()->with('error', 'Something went wrong kid!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Requests $requests)
  {
    //
  }
}
