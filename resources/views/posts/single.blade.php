@extends("layouts.vertical")


@section("css")
  <link href="{{ URL::asset("assets/libs/flatpickr/flatpickr.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section("breadcrumb")
  @if (session("success"))
    <div class="alert alert-success text-center font-bold">
      {{ session("success") }}
    </div>
  @endif

  @if (session("warning"))
    <div class="alert alert-warning text-center font-bold">
      {{ session("warning") }}
    </div>
  @endif

  @if (session("error"))
    <div class="alert alert-warning text-center font-bold">
      {{ session("error") }}
    </div>
  @endif

  <div class="row page-title align-items-center">
    <div class="col-sm-4 col-xl-6">
      <h4 class="mb-1 mt-0">Posts</h4>
    </div>
  </div>

  {{-- Line Divider  --}}
  <div style="height: 2px" class="bg-white rounded w-100 mb-4"></div>
@endsection

@section("content")
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <h3>{{ $post->title }}</h3>
        <a href="{{ asset("storage/" . base64_decode($post->document_url)) }}" target="_blank" class="btn btn-info">View
          document</a>
      </div>
    </div>

    {{-- Line Divider  --}}
    <div style="height: 2px" class="bg-white rounded w-100 mt-4"></div>
    <div class="col-12 mt-4">
      <h5>Comments</h5>
      @role("student|lecturer")
        <form action="{{ route("comment.store") }}" method="POST">
          @csrf
          <div class="row mt-4 mb-4">
            <div class="col-6">
              <textarea class="form-control w-100 m-0" rows="2" name="content" id="content" placeholder="Write a new comment"></textarea>
            </div>
            <div class="col-12 col-md-6 mt-2">
              <input type="hidden" name="post_id" value={{ $post->id }}>
              <button type="submit" class="btn btn-secondary">Comment</button>
            </div>
          </div>
        </form>
      @endrole
      {{-- List comments --}}
      <div class="row flex-col">
        @foreach ($post->comments->sortByDesc("created_at") as $comment)
          <div class="col-12 col-md-6 bg-white px-4 py-2 rounded mb-2 ml-3">

            <div>
              <small class="font-size-12 font-weight-bold mb-1">{{ $comment->commenter->name }}</small>
              @if ($comment->commenter->id == Auth::user()->id)
                <small class="float-right">Delete</small>
              @endif
            </div>
            <p class="mb-1">{{ $comment->content }}</p>
            <small class="font-size-10 text-muted float-right">{{ $comment->created_at }}</small>
          </div>
        @endforeach
      </div>


    </div>
  </div>
@endsection
