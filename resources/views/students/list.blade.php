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

  <div class="row page-title align-items-center">
    <div class="col-sm-4 col-xl-6">
      <h4 class="mb-1 mt-0">Students</h4>
    </div>
    <div class="col-sm-8 col-xl-6">
      <form class="form-inline float-sm-right mt-3 mt-sm-0">
        <div class="btn-group">

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-outline-primary mr-2" data-toggle="modal" data-target="#exampleModal">
            <i class='uil uil-plus mr-1'></i>Add Student
          </button>

        </div>
      </form>
    </div>
  </div>

  {{-- Line Divider  --}}
  <div style="height: 2px" class="bg-white rounded w-100 mb-4"></div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create a new Student</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route("students.create") }}" method="POST">
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
              <button type="submit" class="btn btn-primary">Create Student</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
@endsection

@section("content")
  <div class="row">
    @foreach ($students as $student)
      <div class="col-md-3 col xl-3">
        <a href="#" class="card">
          <div class="card-body p-0">
            <div class="media p-3">
              <div class="media-body">
                <span class="text-muted text-uppercase font-size-12 font-weight-bold">
                  {{ $student->email }}
                </span>
                <h2 class="mb-0 text-capitalize">{{ $student->name }}</h2>
              </div>
              <div class="align-self-center">
                <div id="today-revenue-chart" class="apex-charts"></div>
                <span class="text-success font-weight-bold font-size-18">
                </span>
              </div>
            </div>
          </div>
        </a>
      </div>
    @endforeach

  </div>
@endsection
