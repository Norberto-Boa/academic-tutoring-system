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

@role("student")
  @section("content")
    @if (!Auth::user()->hasProject->isEmpty())
      @foreach (Auth::user()->hasProject as $project)
        <p>{{ $project->topic }}</p>
      @endforeach
      <p>Done Topic</p>
    @elseif (!Auth::user()->hasRequest->isEmpty())
      @foreach (Auth::user()->hasRequest as $_request)
        <div class="col-md-3 col xl-3">
          <a @if (
              ($_request->admin_approval == "pending" && $_request->lecturer_approval == "pending") ||
                  ($_request->admin_approval == "accepted" && $_request->lecturer_approval == "pending") ||
                  ($_request->admin_approval == "pending" && $_request->lecturer_approval == "accepted")) class="card bg-primary text-white"
          @elseif ($_request->admin_approval == "rejected" || $_request->lecturer_approval == "rejected")
            class="card bg-warning text-white"
          @elseif($_request->admin_approval == "accepted" || $_request->lecturer_approval == "accepted")
            class="card bg-success text-white" @endif
            onclick='showDetailsModal(@json($_request->topic), @json($_request->lecturer_id), @json($_request->admin_approval), @json($_request->lecturer_approval), @json($_request->proposal_url))'>
            <div class="card-body p-0">
              <div class="media p-3">
                <div class="media-body d-flex justify-content-between align-items-center">
                  <h2 class="mb-0 text-capitalize text-white" style="cursor: pointer">
                    {{ $_request->topic }}
                  </h2>
                  <div>
                    <button href="#" class="btn btn-info font-size-11 p-1" onclick= 'editStudentModal()'>
                      <i class="uil uil-edit-alt"></i>
                    </button>

                    <button href="#" class="btn btn-danger font-size-11 p-1" onclick='showDeleteModal()'>

                      <i class="uil uil-trash"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="px-3 d-flex justify-content-between">
                <div>
                  <span class="font-weight-bold">Admin: </span>
                  <span class="text-capitalize">{{ $_request->admin_approval }}</span>
                </div>
                <div>
                  <span class="font-weight-bold">Lecturer: </span>
                  <span class="text-capitalize">{{ $_request->lecturer_approval }}</span>
                </div>
              </div>
            </div>
          </a>
        </div>
      @endforeach

      {{-- Request Details Modal --}}
      <div class="modal fade" id="requestDetails" tabindex="-1" aria-labelledby="studentName" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="studentName">Request from {{ auth()->user()->name }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              {{-- Name --}}
              <p class="d-flex justify-content-between">
                <span class="font-weight-bold">Name</span>
                <span id="topic"></span>
              </p>

              {{-- Lecturer --}}
              <p class="d-flex justify-content-between">
                <span class="font-weight-bold">Lecturer</span>
                <span id="lecturer"></span>
              </p>

              {{-- Status --}}
              <p class="d-flex justify-content-between">
                <span class="font-weight-bold">Status</span>
                <span id="approved"></span>
              </p>

              {{-- Proposal documet --}}
              <a href="" target="_blank" id="file">Download the proposal</a>
            </div>
            <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-info w-50" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <script>
        function showDetailsModal(topic, lecturer, adminApproval, lecturerApproval, file) {
          document.getElementById('topic').innerHTML = topic;
          document.getElementById('lecturer').innerHTML = lecturer;
          if (adminApproval == 'pending' || lecturerApproval == 'pending') {
            document.getElementById('approved').innerHTML = "Pending";
          } else if (adminApproval == 'rejected' || lecturerApproval == 'rejected') {
            document.getElementById('approved').innerHTML = "Rejected";
          } else {
            document.getElementById('approved').innerHTML = "Accepted";
          }
          document.getElementById('file').href =
            "{{ asset('storage/proposals/' . $_request->proposal_url . '.pdf') }}";
          $("#requestDetails").modal('show');
        }
      </script>
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
              <form action="{{ route("request.store") }}" method="POST" enctype="multipart/form-data">
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
                    <select class="form-control custom-select" name="lecturer_id">
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
                    <textarea class="form-control" rows="5" name="description" id="description"
                      placeholder="Write at maximum 200 words."></textarea>
                  </div>
                </div>

                {{-- File Input --}}
                <div class="form-group row">
                  <div class="col-lg-10">
                    <input type="file" name="proposal" class="form-control-file" id="example-fileinput">
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
@endrole
