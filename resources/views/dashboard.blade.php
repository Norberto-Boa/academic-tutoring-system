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
      <h4 class="mb-1 mt-0">Dashboard</h4>
    </div>
    {{-- <div class="col-sm-8 col-xl-6">
      <form class="form-inline float-sm-right mt-3 mt-sm-0">
        <div class="btn-group">
        </div>
      </form>
    </div> --}}
  </div>

  {{-- Line Divider  --}}
  <div style="height: 2px" class="bg-white rounded w-100 mb-4"></div>
@endsection

@section("content")
  @if (!Auth::user()->hasProject)
    @foreach (Auth::user()->hasProject as $project)
      <p>{{ $project->topic }}</p>
    @endforeach
  @else
    <div class="alert alert-info text-center font-bold text-white font-weight-bold" role="alert">
      You do not have a project yet!
    </div>

    <!-- Button trigger modal -->
    <div class="row justify-content-center">
      <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#request">
        <i class='uil uil-plus mr-1'></i>Submit Request for Project
      </button>
    </div>

    {{-- Submit Request Modal --}}
    <div class="modal fade" id="request" tabindex="-1" aria-labelledby="requestLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="requestLabel">Submit Project Proposal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route("lecturers.create") }}" method="POST">
              @csrf
              {{-- Topic Input --}}
              <div class="form-group">
                <label for="topic">Topic</label>
                <input type="text" class="form-control" name="topic" id="topic" placeholder="Example: John Doe">
              </div>

              {{-- Lecturer Input --}}
              <div class="form-group row">
                <label class="col-lg-4 col-form-label">Select Lecturer</label>
                <div class="col-lg-12">
                  <select class="form-control custom-select">
                    <option>Select a Lecturer</option>
                    @foreach ($lecturers as $lecturer)
                      <option value="{{ $lecturer->id }}" class="text-capitalize">{{ $lecturer->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="description">Description</label>
                <div class="col-lg-12">
                  <textarea class="form-control" rows="5" id="description" placeholder="Write at maximum 200 words."></textarea>
                </div>
              </div>

              {{-- File Input --}}
              <div class="form-group row">
                <div class="col-lg-10">
                  <input type="file" class="form-control-file" id="example-fileinput">
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit Proposal</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  @endif
@endsection
