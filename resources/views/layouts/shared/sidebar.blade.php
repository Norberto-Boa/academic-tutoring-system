<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
  <div class="media user-profile mt-2 mb-2">
    <img src="{{ URL::asset("assets//images/users/avatar-7.jpg") }}" class="avatar-sm rounded-circle mr-2"
      alt="Shreyu" />
    <img src="{{ URL::asset("assets//images/users/avatar-7.jpg") }}" class="avatar-xs rounded-circle mr-2"
      alt="Shreyu" />

    <div class="media-body">
      <h6 class="pro-user-name mt-0 mb-0">{{ auth()->user()->name }}</h6>
      <span class="pro-user-desc">
        @hasrole("admin")
          Administrator
        @endhasrole

        @hasrole("student")
          Student
        @endhasrole

        @hasrole("lecturer")
          Lecturer
        @endhasrole
      </span>
    </div>
    <div class="dropdown align-self-center profile-dropdown-menu">
      <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
        aria-expanded="false">
        <span data-feather="chevron-down"></span>
      </a>
      <div class="dropdown-menu profile-dropdown">
        <a href="{{ route("profile.edit") }}" class="dropdown-item notify-item">
          <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
          <span>My Account</span>
        </a>
        <div class="dropdown-divider"></div>

        <a href="{{ route("logout") }}" class="dropdown-item notify-item"
          onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
          <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
          <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route("logout") }}" method="POST" class="d-none">
          @csrf
        </form>
      </div>
    </div>
  </div>
  <div class="sidebar-content">
    <!--- Sidemenu -->
    <div id="sidebar-menu" class="slimscroll-menu">
      @include("layouts.shared.app-menu")
    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>
  </div>
  <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
