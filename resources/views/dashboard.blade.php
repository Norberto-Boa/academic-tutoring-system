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
    <div class="col-sm-8 col-xl-6">
      <form class="form-inline float-sm-right mt-3 mt-sm-0">
        <div class="btn-group">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-outline-primary mr-2" data-toggle="modal" data-target="#exampleModal">
            <i class='uil uil-plus mr-1'></i>Add Lecturers
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- Line Divider  --}}
  <div style="height: 2px" class="bg-white rounded w-100 mb-4"></div>

  <!-- Create Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create a new Project</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route("lecturers.create") }}" method="POST">
            @csrf
            {{-- Phone Number Input --}}
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Example: John Doe">
            </div>

            {{-- Email Input --}}
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                placeholder="example@ustm.ac.mz">
              {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                else.
                </small> 
                --}}
            </div>

            {{-- Phone Number Input --}}
            <div class="form-group">
              <label for="phone_number">Phone Number</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">+258</div>
                </div>
                <input type="text" class="form-control" id="phone_number" name="phone_number"
                  placeholder="84 000 0000">
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Create Lecturer</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
@endsection

@section("content")
  @if (Auth::user()->hasProject)
    @foreach (Auth::user()->hasProject as $project)
      <p>{{ $project->topic }}</p>
    @endforeach
  @else
    <div class="alert alert-info text-center font-bold text-white font-weight-bold" role="alert">
      You do not have a project yet!
    </div>
  @endif
@endsection
