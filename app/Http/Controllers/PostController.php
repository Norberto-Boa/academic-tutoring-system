<?php

namespace App\Http\Controllers;

use App\Models\LecturerStudent;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
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
   */
  public function store(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'projectId' => ['integer', 'required'],
        'title' => ['string', 'required'],
        'description' => ['string', 'required'],
        'document' => ['file', 'mimes:pdf']
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }
    } catch (\Throwable $th) {
      throw $th;
    }

    $data = $request->all();
    $project = LecturerStudent::find($data['projectId']);

    if ($project->student->id !== Auth::user()->id) {
      return redirect()->back()->with('warning', "Don't try to fool us bro!");
    }

    if (!$data['document']) {
      $document = "Not-saved";
    } else {
      $directory = 'posts/documents/' . base64_encode($project->id);

      if (!Storage::disk('public')->exists($directory)) {
        Storage::disk('public')->makeDirectory($directory);
      }

      $document = $request->file('document')->store($directory, 'public');
    }


    $post = new Post();
    $post->title = $data['title'];
    $post->description = $data['description'];
    $post->student_lecturer_id = $data['projectId'];
    $post->document_url = base64_encode($document);
    $post->save();

    return redirect()->back()->with('success', "Your post has been saved successfully!");
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $post = Post::find($id);

    if (!$post) {
      return redirect()->back()->with('warning', 'Post was not found!');
    }

    return response(view('', compact('post')));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function update(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'id' => ['required', 'integer'],
        'title' => ['required', 'string'],
        'description' => ['required', 'string'],
        'file' => ['file', 'mimes:pdf']
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }
    } catch (\Throwable $th) {
      throw $th;
    }

    $data = $request->all();
    $post = Post::find($data['id']);
    if (!$post) {
      return redirect()->back()->with('warning', 'Post was not found!');
    }

    $post->title = $data['title'];
    $post->description = $data['description'];
    if ($request->file('document')) {
      $directory = 'posts/documents/' . base64_encode($post->project->id);

      if (!Storage::disk('public')->exists($directory)) {
        Storage::disk('public')->makeDirectory($directory);
      }
      $document = $request->file('document')->store($directory, 'public');
      $post->document_url = $document;
    }
    $post->update();

    return redirect()->back()->with('success', 'Post was successfully updated.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'id' => ['required', 'integer']
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }
    } catch (\Throwable $th) {
      throw $th;
    }

    $id = $request->id;
    $post = Post::find($id);

    if (!$post) {
      return redirect()->back()->with('warning', 'No post found');
    }

    $post->delete();
    return redirect()->back()->with('success', 'Post deleted successfully');
  }
}
