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
      <h4 class="mb-1 mt-0">Proposals</h4>
    </div>
  </div>

  {{-- Line Divider  --}}
  <div style="height: 2px" class="bg-white rounded w-100 mb-4"></div>
@endsection

@role("admin")
  @section("content")
    @foreach ($_requests as $_request)
      <div class="col-md-3 col xl-3">
        <a
          @if (
              ($_request->admin_approval == "pending" && $_request->lecturer_approval == "pending") ||
                  ($_request->admin_approval == "accepted" && $_request->lecturer_approval == "pending") ||
                  ($_request->admin_approval == "pending" && $_request->lecturer_approval == "accepted")) class="card bg-primary text-white"
          @elseif ($_request->admin_approval == "rejected" || $_request->lecturer_approval == "rejected")
            class="card bg-warning text-white"
          @elseif($_request->admin_approval == "accepted" || $_request->lecturer_approval == "accepted")
            class="card bg-success text-white" @endif>
          <div class="card-body p-0">
            <div class="media p-3">
              <div class="media-body d-flex justify-content-between align-items-center">
                <h2 class="mb-0 text-capitalize text-white" style="cursor: pointer"
                  onclick='showDetailsModal(@json($_request->topic), @json($_request->lecturer->name), @json($_request->admin_approval), @json($_request->lecturer_approval), @json($_request->proposal_url), @json($_request->student_id), @json($_request->description))'>
                  {{ $_request->topic }}
                </h2>
                <div>
                  {{-- <button href="#" class="btn btn-info font-size-11 p-1" onclick= 'editStudentModal()'>
                    <i class="uil uil-edit-alt"></i>
                  </button>

                  <button href="#" class="btn btn-danger font-size-11 p-1" onclick='showDeleteModal()'>
                    <i class="uil uil-trash"></i>
                  </button> --}}
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
    <div class="modal fade" id="requestDetails" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Request from <span id="studentName"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            {{-- Name --}}
            <p class="d-flex justify-content-between">
              <span class="font-weight-bold">Topic</span>
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

            {{-- Description --}}
            <p id="description"></p>
            {{-- Proposal documet --}}
            <a href="" target="_blank" id="file">View the proposal document</a>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-info w-50" data-dismiss="modal">Close</button>
            <a id="requestSingle" class="btn btn-info w-50 text-white" target="_blank">Give Feedback</a>
          </div>
        </div>
      </div>
    </div>



    <script>
      function showDetailsModal(topic, lecturer, adminApproval, lecturerApproval, file, student, description) {
        document.getElementById('topic').innerHTML = topic;
        document.getElementById('studentName').innerHTML = student;
        document.getElementById('lecturer').innerHTML = lecturer;
        document.getElementById('description').innerHTML = description;
        if (adminApproval == 'pending' || lecturerApproval == 'pending') {
          document.getElementById('approved').innerHTML = "Pending";
        } else if (adminApproval == 'rejected' || lecturerApproval == 'rejected') {
          document.getElementById('approved').innerHTML = "Rejected";
        } else {
          document.getElementById('approved').innerHTML = "Accepted";
        }
        document.getElementById('file').href =
          '{{ asset("storage/" . base64_decode($_request->proposal_url)) }}';
        document.getElementById('requestSingle').href = '{{ route("request.showByRequestId", $_request->id) }}'
        $("#requestDetails").modal('show');
      }
    </script>
  @endsection
@endrole
@role("lecturer")
  @section("content")
    <div class="row">
      @foreach (Auth::user()->hasRequests as $_request)
        <div class="col-md-3 col xl-3">
          <a
            @if (
                ($_request->admin_approval == "pending" && $_request->lecturer_approval == "pending") ||
                    ($_request->admin_approval == "accepted" && $_request->lecturer_approval == "pending") ||
                    ($_request->admin_approval == "pending" && $_request->lecturer_approval == "accepted")) class="card bg-primary text-white"
          @elseif ($_request->admin_approval == "rejected" || $_request->lecturer_approval == "rejected")
            class="card bg-warning text-white"
          @elseif($_request->admin_approval == "accepted" || $_request->lecturer_approval == "accepted")
            class="card bg-success text-white" @endif>
            <div class="card-body p-0">
              <div class="media p-3">
                <div class="media-body d-flex justify-content-between align-items-center">
                  <h2 class="mb-0 text-capitalize text-white" style="cursor: pointer"
                    onclick='showDetailsModal(@json($_request->topic), @json($_request->student->name), @json($_request->admin_approval), @json($_request->lecturer_approval), @json($_request->proposal_url), @json($_request->description))'>
                    {{ $_request->student->name }}
                  </h2>
                  <div>
                    {{-- <button href="#" class="btn btn-info font-size-11 p-1"
                      onclick= 'editProposalModal(@json($_request->id), @json($_request->topic), @json($_request->description), @json($_request->lecturer_id))'>
                      <i class="uil uil-edit-alt"></i>
                    </button>

                    <button href="#" class="btn btn-danger font-size-11 p-1"
                      onclick='showDeleteModal(@json($_request->id))'>

                      <i class="uil uil-trash"></i>
                    </button> --}}
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
    </div>

    {{-- Request Details Modal --}}
    <div class="modal fade" id="requestDetails" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Request </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            {{-- Name --}}
            <p class="d-flex justify-content-between">
              <span class="font-weight-bold">Topic</span>
              <span id="topic"></span>
            </p>

            {{-- Lecturer --}}
            <p class="d-flex justify-content-between">
              <span class="font-weight-bold">Student</span>
              <span id="student"></span>
            </p>

            {{-- Status --}}
            <p class="d-flex justify-content-between">
              <span class="font-weight-bold">Status</span>
              <span id="approved"></span>
            </p>

            {{-- Description --}}
            <p id="description"></p>
            {{-- Proposal documet --}}
            <a href="" target="_blank" id="file">View the proposal document</a>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-info w-50" data-dismiss="modal">Close</button>
            <a id="requestSingle" class="btn btn-info w-50 text-white" target="_blank">Give Feedback</a>
          </div>
        </div>
      </div>
    </div>

    <script>
      function showDetailsModal(topic, student, adminApproval, lecturerApproval, file, description) {
        document.getElementById('topic').innerHTML = topic;
        document.getElementById('student').innerHTML = student;
        document.getElementById('description').innerHTML = description;
        if (adminApproval == 'pending' || lecturerApproval == 'pending') {
          document.getElementById('approved').innerHTML = "Pending";
        } else if (adminApproval == 'rejected' || lecturerApproval == 'rejected') {
          document.getElementById('approved').innerHTML = "Rejected";
        } else {
          document.getElementById('approved').innerHTML = "Accepted";
        }
        document.getElementById('file').href =
          '{{ asset("storage/" . base64_decode($_request->proposal_url)) }}';
        document.getElementById('requestSingle').href = '{{ route("request.showByRequestId", $_request->id) }}'
        $("#requestDetails").modal('show');
      }
    </script>
  @endsection
@endrole
