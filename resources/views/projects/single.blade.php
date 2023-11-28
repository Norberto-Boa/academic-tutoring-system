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
      <h4 class="mb-1 mt-0">Project</h4>
    </div>
  </div>

  {{-- Line Divider  --}}
  <div style="height: 2px" class="bg-white rounded w-100 mb-4"></div>
@endsection

@hasanyrole("admin|lecturer")
  @section("content")
    <div class="row">
      <div class="col-12">
        <h4>{{ $project->topic }}</h4>
        <h5>
          <span class="font-weight-bold">Lecturer:</span>
          <span>{{ $project->lecturer->name }}</span>
        </h5>
        <h5>
          <span class="font-weight-bold">Student:</span>
          <span>{{ $project->student->name }}</span>
        </h5>
        <a href="{{ asset("storage/" . base64_decode($project->proposal_url)) }}"
          target="_blank"class="btn btn-info py-1 px-4">Check proposal</a>
      </div>
    </div>
    <div style="height: 2px" class="bg-white rounded w-100 mb-4 mt-4"></div>
  @endsection
@endhasanyrole
