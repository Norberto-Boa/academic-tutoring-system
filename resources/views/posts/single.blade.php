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
  @role("student")
    <div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
          <h3>{{ $post->title }}</h3>
          <a href="{{ asset("storage/" . base64_decode($post->document_url)) }}" target="_blank" class="btn btn-info">View
            document</a>
        </div>
      </div>
      <div class="col-12 mt-4">
        <h5>Comments</h5>

        <div class="row flex-col">
          <div class="col-12 col-md-6 bg-white px-4 py-2 rounded">
            <small class="font-size-12 font-weight-bold mb-1">Norberto Boa</small>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat ea exercitationem qui, cum hic consequatur
              quidem totam eius doloremque delectus!
            </p>
            <small class="font-size-10 text-muted float-right ">Friday, 13 November 2023</small>
          </div>
        </div>
      </div>
    </div>
  @endrole
@endsection
