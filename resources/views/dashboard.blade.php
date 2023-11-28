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
    {{-- Check if it has Projects --}}
    @if (!Auth::user()->hasProject->isEmpty())
      <div class="row">
        {{-- Project Topic --}}
        <div class="col-12">
          <h2>{{ Auth::user()->project->topic }}</h2>
        </div>
        {{-- View Project Proposal pdf --}}
        <div class="col-12">
          <a href="{{ asset("storage/" . base64_decode(Auth::user()->project->proposal_url)) }}" class="btn btn-info"
            target="_blank">Open
            Proposal</a>
        </div>
      </div>
      {{-- Divider Line --}}
      <div style="height: 2px" class="bg-white rounded w-100 mb-4 mt-4"></div>

      {{-- List Posts --}}
      <div class="row">
        <div class="col-12">
          <div class="h2">Posts</div>
        </div>

        @php
          $project = Auth::user()->project;
        @endphp

        @if (!$project->posts->isEmpty())
          @foreach (Auth::user()->project->posts as $post)
            <div class="col-12 mt-2">
              <div class=" py-1 px-4 border border-secondary rounded d-flex justify-content-between align-items-center">
                <div>
                  <a href="{{ route("post.show", $post->id) }}" class="font-size-22 text-secondary">{{ $post->title }}</a>
                </div>

                <div>
                  <button href="#" class="btn btn-info font-size-15 p-1"
                    onclick= 'editPostModal(@json($post->id), @json($post->title), @json($post->description))'>
                    <i class="uil uil-edit-alt"></i>
                  </button>

                  <button href="#" class="btn btn-danger font-size-15 p-1"
                    onclick='deletePostModal(@json($post->id), @json($post->title))'>
                    <i class="uil uil-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          @endforeach

          {{-- Edit Modal --}}
          <div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="projectTopic" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  {{-- Modal Title --}}
                  <h5 class="modal-title" id="projectTopic">Edit <span id="Title"></span></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  {{-- Modal Form --}}
                  <form action="{{ route("post.update") }}" method="post" enctype="multipart/form-data">
                    @csrf

                    {{-- Project ID --}}
                    <input type="hidden" name="id" id="postId">

                    {{-- Title Input --}}
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" name="title" id="editTitle"
                        placeholder="Example: John Doe">
                    </div>

                    {{-- Description Input --}}
                    <div class="form-group row">
                      <label class="col-lg-4 col-form-label" for="editDescription">Description</label>
                      <div class="col-lg-12">
                        <textarea class="form-control" rows="5" name="description" id="editDescription"
                          placeholder="Write at maximum 200 words."></textarea>
                      </div>
                    </div>

                    {{-- File Input --}}
                    <div class="form-group row">
                      <div class="col-lg-12">
                        <input type="file" name="document" class="form-control-file" id="fileInput">
                        <small>Upload even if it is the same file!</small>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-primary">Edit Post</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          {{-- Delete Modal --}}
          <div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deletePostModalLabel">Delete <span id="postTitle"></span></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>You sure you want to delete the proposal?</p>
                </div>
                <div class="modal-footer">

                  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                  <form action="{{ route("post.destroy") }}" method="POST" id="deleteForm">
                    @csrf
                    <input type="hidden" name="id" id="deleteId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <script>
            function editPostModal(postId, title, description) {

              document.getElementById('Title').innerHTML = title;
              document.getElementById('postId').value = postId;
              document.getElementById('editTitle').value = title;
              document.getElementById('editDescription').value = description;
              $('#editPostModal').modal('show');
            }

            function deletePostModal(postId, title) {
              document.getElementById('postTitle').innerHTML = title;
              document.getElementById('deleteId').value = postId;
              $('#deletePostModal').modal('show');
            }
          </script>
        @else
          <div class="col-12">
            <div class="alert alert-danger w-25">
              You do not have a post yet!
            </div>
          </div>
        @endif
        <div class="col-12 mt-2">
          <a href="#" class="btn btn-dark" onclick="createPostModal()">
            <i data-feather="plus"></i>
            Create a Post
          </a>
        </div>
      </div>

      {{-- Create Post Modal --}}
      <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="projectTopic" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              {{-- Modal Title --}}
              <h5 class="modal-title" id="projectTopic">Create Post for {{ $project->topic }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              {{-- Modal Form --}}
              <form action="{{ route("post.store") }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Project ID --}}
                <input type="hidden" name="projectId" value="{{ $project->id }}">

                {{-- Title Input --}}
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" class="form-control" name="title" id="title"
                    placeholder="Example: John Doe">
                </div>

                {{-- Description Input --}}
                <div class="form-group row">
                  <label class="col-lg-4 col-form-label" for="description">Description</label>
                  <div class="col-lg-12">
                    <textarea class="form-control" rows="5" name="description" id="description"
                      placeholder="Write at maximum 200 words."></textarea>
                  </div>
                </div>

                {{-- File Input --}}
                <div class="form-group row">
                  <div class="col-lg-12">
                    <input type="file" name="document" class="form-control-file" id="fileInput">
                    <small>Upload even if it is the same file!</small>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Create Post</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <script>
        function createPostModal() {
          $('#createPostModal').modal('show');
        }
      </script>

      {{-- Check if it has proposals  --}}
    @elseif (!Auth::user()->hasRequest->isEmpty())
      @foreach (Auth::user()->hasRequest as $_request)
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
                    onclick='showDetailsModal(@json($_request->topic), @json($_request->lecturer->name), @json($_request->admin_approval), @json($_request->lecturer_approval), @json($_request->proposal_url))'>
                    {{ $_request->topic }}
                  </h2>
                  <div>
                    <button href="#" class="btn btn-info font-size-11 p-1"
                      onclick= 'editProposalModal(@json($_request->id), @json($_request->topic), @json($_request->description), @json($_request->lecturer_id))'>
                      <i class="uil uil-edit-alt"></i>
                    </button>

                    <button href="#" class="btn btn-danger font-size-11 p-1"
                      onclick='showDeleteModal(@json($_request->id))'>

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

      {{-- Update Proposal Modal --}}
      <div class="modal fade" id="editProposalModal" tabindex="-1" aria-labelledby="editTitle" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editTitle"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route("request.update") }}" method="POST" id="editProposalForm"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="editId">
                {{-- Topic Input --}}
                <div class="form-group">
                  <label for="editTopic">Topic</label>
                  <input type="text" class="form-control" name="topic" id="editTopic"
                    placeholder="Example: John Doe">
                </div>

                {{-- Lecturer Input --}}
                <div class="form-group row">
                  <label class="col-lg-4 col-form-label">Select Lecturer</label>
                  <div class="col-lg-12">
                    <select class="form-control custom-select" name="lecturer_id" id="editLecturer">
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
                    <textarea class="form-control" rows="5" name="description" id="editDescription"
                      placeholder="Write at maximum 200 words."></textarea>
                  </div>
                </div>

                {{-- File Input --}}
                <div class="form-group row">
                  <div class="col-lg-12">
                    <input type="file" name="proposal" class="form-control-file" id="fileInput">
                    <small>Upload even if it is the same file!</small>
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

      {{-- Delete Proposal Modal --}}
      <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Delete the Proposal <span id="propId"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>You sure you want to delete the proposal?</p>
            </div>
            <div class="modal-footer">

              <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
              <form action="" method="POST" id="deleteForm">
                @csrf
                <input type="hidden" name="id" id="deleteId">
                <button type="button" class="btn btn-danger">Delete</button>
              </form>
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
            "{{ asset("storage/proposals/" . $_request->proposal_url . ".pdf") }}";
          $("#requestDetails").modal('show');
        }

        function editProposalModal(requestId, topic, description, lecturer) {
          var form = document.getElementById('editProposal');

          document.getElementById('editTitle').innerHTML = 'Edit proposal ' + topic;
          document.getElementById('editId').value = requestId;
          document.getElementById('editTopic').value = topic;
          document.getElementById('editLecturer').value = lecturer;
          document.getElementById('editDescription').value = description;

          $('#editProposalModal').modal('show');
        }

        function showDeleteModal(requestId) {
          var form = document.getElementById("deleteForm");

          document.getElementById("propId").innerHTML = requestId;
          document.getElementById("deleteId").value = requestId;

          $("#deleteModal").modal('show');
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
                  <input type="text" class="form-control" name="topic" id="topic"
                    placeholder="Example: John Doe">
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
