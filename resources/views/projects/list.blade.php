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
      <h4 class="mb-1 mt-0">Projects</h4>
    </div>
  </div>

  {{-- Line Divider  --}}
  <div style="height: 2px" class="bg-white rounded w-100 mb-4"></div>
@endsection

@role("admin")
  @section("content")
    <div class="row">
      @foreach ($projects as $project)
        <div class="col-md-3 col xl-3">
          <a class="card cursor-pointer">
            <div class="card-body p-0">
              <div class="media p-3">
                <div class="media-body d-flex justify-content-between align-items-center">
                  @php
                    $studentName = $students->find($project->student_id)->name;
                    $lecturerName = $lecturers->find($project->lecturer_id)->name;
                  @endphp
                  <h2 class="mb-0 text-capitalize" style="cursor: pointer"
                    onclick='showDetailsModal({{ $project->id }}, @json($project->topic), @json($studentName), @json($lecturerName))'>
                    {{ $students->find($project->student_id)->name }}</h2>
                  <div>
                    {{-- <button href="#" class="btn btn-info font-size-11 p-1"
                    onclick= 'editlecturerModal({{ $lecturer->id }},@json($lecturer->name),@json($lecturer->email),@json($lecturer->phone_number))'>
                    <i class="uil uil-edit-alt"></i>
                  </button>

                  <button href="#" class="btn btn-danger font-size-11 p-1"
                    onclick='showDeleteModal({{ $lecturer->id }},@json($lecturer->name))'>

                    <i class="uil uil-trash"></i>
                  </button> --}}
                  </div>
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

      <!-- Details Modal -->
      <div class="modal fade" id="projectDetails" tabindex="-1" aria-labelledby="lecturerName" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              {{-- Name --}}
              <p class="d-flex justify-content-between">
                <span class="font-weight-bold">Topic</span>
                <span id="projectTopic"></span>
              </p>

              {{-- Email --}}
              <p class="d-flex justify-content-between">
                <span class="font-weight-bold">Student Name</span>
                <span id="stuName"></span>
              </p>

              {{-- Phone Number --}}
              <p class="d-flex justify-content-between">
                <span class="font-weight-bold">Lecturer Name</span>
                <span id="lecName"></span>
              </p>
            </div>
            <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-info w-50" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Delete Modal -->
      {{-- <div class="modal fade" id="deletelecturer" tabindex="-1" aria-labelledby="deletelecturerLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-capitalize" id="LecturerName"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Tem certeza que pretende apagar o aluno <strong id="StuName"></strong>?</p>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form action="" id="lecturerRemovalForm" method="POST">
              @csrf
              <input type="hidden" name="id" id="removelecturerId">
              <button type="submit" class="btn btn-danger">Delete lecturer</button>
            </form>
          </div>
        </div>
      </div>
    </div> --}}

      {{-- Edit Modal --}}

      <div class="modal fade" id="editlecturer" tabindex="-1" aria-labelledby="deletelecturerLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editTitle"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="POST" id="editlecturerForm">
                @csrf

                <input type="hidden" name="id" id="editId">
                {{-- Name Input --}}
                <div class="form-group">
                  <label for="editName">Name</label>
                  <input type="text" class="form-control" name="name" id="editName" placeholder="Example: John Doe">
                </div>

                {{-- Email Input --}}
                <div class="form-group">
                  <label for="editEmail">Email address</label>
                  <input type="email" class="form-control" name="email" id="editEmail" aria-describedby="emailHelp"
                    placeholder="example@ustm.ac.mz">
                  {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                else.
                </small> 
                --}}
                </div>

                {{-- Phone Number Input --}}
                <div class="form-group">
                  <label for="editPhone_number">Phone Number</label>
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text">+258</div>
                    </div>
                    <input type="text" class="form-control" id="editPhone_number" name="phone_number"
                      placeholder="84 000 0000">
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Edit lecturer</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>

    <script>
      function showDetailsModal(projectId, projectTopic, studentName, lecturerName) {
        document.getElementById('title').innerHTML = studentName +
          ' final project';
        document.getElementById('projectTopic').innerHTML = projectTopic;
        document.getElementById('stuName').innerHTML = studentName;
        document.getElementById('lecName').innerHTML = lecturerName;
        $("#projectDetails").modal('show');
      }

      function showDeleteModal(lecturerId, lecturerName) {
        var form = document.getElementById('lecturerRemovalForm');

        form.action = "{{ route("lecturers.destroy") }}";

        document.getElementById('removelecturerId').value = lecturerId;
        document.getElementById('LecturerName').innerHTML = lecturerName;
        document.getElementById('StuName').innerHTML = lecturerName;
        $("#deletelecturer").modal('show');
      }

      function editlecturerModal(lecturerId, lecturerName, lecturerEmail, lecturerPhone) {
        var form = document.getElementById('editlecturerForm');

        form.action = "{{ route("lecturers.update") }}";

        document.getElementById('editId').value = lecturerId;
        document.getElementById('editTitle').innerHTML = `Edit lecturer of name ${lecturerName}`
        document.getElementById('editName').value = lecturerName;
        document.getElementById('editEmail').value = lecturerEmail;
        document.getElementById('editPhone_number').value = lecturerPhone;
        $("#editlecturer").modal('show');
      }
    </script>
  @endsection
@else
  @section("content")
    <div class="alert alert-warning text-center font-bold text-white font-weight-bold">
      You don't have the permission to access this page!
    </div>
  @endsection
@endrole
