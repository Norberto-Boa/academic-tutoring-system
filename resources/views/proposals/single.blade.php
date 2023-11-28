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
      <h4 class="mb-1 mt-0">Proposal</h4>
    </div>
  </div>

  {{-- Line Divider  --}}
  <div style="height: 2px" class="bg-white rounded w-100 mb-4"></div>
@endsection

@section("content")
  <div class="row">
    <div class="col-12">
      <h2>
        {{ $_request->topic }}
      </h2>
    </div>
    <div class="col-12">
      <p class="font-size-20">
        <span>{{ $_request->description }}</span>
      </p>
    </div>

    <div class="col-12">
      <p class="font-weight-bold">Student: <span class="font-weight-normal">{{ $_request->student->name }}</span></p>
    </div>

    <div class="col-12">
      <a href="{{ asset("storage/" . base64_decode($_request->proposal_url)) }}" target='_blank'
        class="btn btn-outline-primary">
        Check the Proposal
      </a>
    </div>


    @role("admin")
      @if ($_request->admin_approval == "pending")
        <div class="col-12 mt-4">
          <button href="#" class="btn btn-success font-size-16 py-1 px-4" data-toggle="modal"
            data-target="#acceptanceModal">
            <i class="uil uil-check"></i> Accept
          </button>

          <button href="#" class="btn btn-danger font-size-16 py-1 px-4 ml-2" data-toggle="modal"
            data-target="#rejectModal">
            <i class="uil uil-ban"></i> Reject
          </button>
        </div>
      @elseif ($_request->admin_approval == "accepted")
        <div class="col-12 col-md-4 mt-4">
          <div class="alert alert-info text-center font-bold">
            {{ "The Proposal has been Accepted by the administration and Lecturer" }}
          </div>
        </div>

        <div class="col-12 mt-4">
          <button href="#" class="btn btn-success font-size-16 py-1 px-4" data-toggle="modal"
            data-target="#reopenRequestModal">
            <i class="uil uil-check"></i> Reopen the request
          </button>
        </div>
      @elseif ($_request->admin_approval == "rejected")
        <div class="col-12 col-md-4 mt-4">
          <div class="alert alert-danger text-center font-bold">
            {{ "The Proposal has been rejected by the administration and Lecturer" }}
          </div>
        </div>
      @endif
    @endrole

    @role("lecturer")
      @if ($_request->lecturer_approval == "pending")
        <div class="col-12 mt-4">
          <button href="#" class="btn btn-success font-size-16 py-1 px-4" data-toggle="modal"
            data-target="#acceptanceModal">
            <i class="uil uil-check"></i> Accept
          </button>

          <button href="#" class="btn btn-danger font-size-16 py-1 px-4 ml-2" data-toggle="modal"
            data-target="#rejectModal">
            <i class="uil uil-ban"></i> Reject
          </button>
        </div>
      @elseif ($_request->lecturer_approval == "accepted" && $_request->admin_approval == "accepted")
        <div class="col-12 col-md-4 mt-4">
          <div class="alert alert-info text-center font-bold">
            {{ "You have Accepted the project from this student" }}
          </div>
        </div>
      @elseif ($_request->lecturer_approval == "accepted" && $_request->admin_approval == "pending")
        <div class="col-12 col-md-4 mt-4">
          <div class="alert alert-info text-center font-bold">
            {{ "You have Accepted the project from this student!" }}
          </div>
        </div>
        <div class="col-12 mt-4">
          <button href="#" class="btn btn-success font-size-16 py-1 px-4" data-toggle="modal"
            data-target="#reopenRequestModal">
            <i class="uil uil-check"></i> Reopen the request
          </button>
        </div>
      @elseif($_request->lecturer_approval == "rejected")
        <div class="col-12 col-md-4 mt-4">
          <div class="alert alert-danger text-center font-bold">
            {{ "You have Rejected the project from this student!" }}
          </div>
        </div>
        <div class="col-12 mt-4">
          <button href="#" class="btn btn-success font-size-16 py-1 px-4" data-toggle="modal"
            data-target="#reopenRequestModal">
            <i class="uil uil-check"></i> Reopen the request
          </button>
        </div>
      @endif
    @endrole
  </div>

  {{-- Acceptance Modal --}}
  <div class="modal fade" id="acceptanceModal" tabindex="-1" aria-labelledby="acceptanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="acceptanceModalLabel">Accept the Proposal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>You sure you want to accept the proposal from?</p>
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
          <form @role("admin")
              action="{{ route("request.feedback") }}" 
            @endrole
            @role("lecturer")
              action="{{ route("request.lecturer.feedback") }}" 
            @endrole
            method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $_request->id }}">
            <input type="hidden" name="feedback" value="accepted" />
            <button type="submit" class="btn btn-success">Accept</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Reject Modal --}}
  <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rejectModalLabel">Reject the Proposal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>You sure you want to reject the proposal from?</p>
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
          <form @role("admin")
              action="{{ route("request.feedback") }}" 
            @endrole
            @role("lecturer")
              action="{{ route("request.lecturer.feedback") }}" 
            @endrole
            method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $_request->id }}">
            <input type="hidden" name="feedback" value="rejected">
            <button type="submit" class="btn btn-danger">Reject</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- R-eopen Request Modal --}}
  <div class="modal fade" id="reopenRequestModal" tabindex="-1" aria-labelledby="reopenRequestModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reopenRequestModalLabel">Reject the Proposal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>You sure you want to re open the proposal?</p>
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
          <form @role("admin")
              action="{{ route("request.feedback") }}" 
            @endrole
            @role("lecturer")
              action="{{ route("request.lecturer.feedback") }}" 
            @endrole
            method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $_request->id }}">
            <input type="hidden" name="feedback" value="pending">
            <button type="submit" class="btn btn-warning">Re-Open</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
