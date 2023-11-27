<ul class="metismenu" id="menu-bar">
  <li class="menu-title">Navigation</li>

  <li>
    <a href="{{ route("dashboard") }}">
      <i data-feather="home"></i>
      <span class="badge badge-success float-right">1</span>
      <span> Dashboard </span>
    </a>
  </li>

  <li>
    <a href="/">
      <i data-feather="home"></i>
      <span> Posts </span>
    </a>
  </li>

  {{-- Dropdown --}}
  <li>
    <a href="javascript: void(0);">
      <i data-feather="inbox"></i>
      <span> Email </span>
      <span class="menu-arrow"></span>
    </a>

    <ul class="nav-second-level" aria-expanded="false">
      <li>
        <a href="/apps/email/inbox">Inbox</a>
      </li>
      <li>
        <a href="/apps/email/read">Read</a>
      </li>
      <li>
        <a href="/apps/email/compose">Compose</a>
      </li>
    </ul>
  </li>

  @if (Auth::user()->hasRole("lecturer"))
    <li class="menu-title">Administration</li>
    <li>
      <a href="{{ route("projects.list") }}">
        <i data-feather="book"></i>
        <span> Projects </span>
      </a>
    </li>

    <li>
      <a href="{{ route("request.list") }}">
        <i data-feather="git-pull-request"></i>
        <span> Proposals </span>
      </a>
    </li>
  @endif

  @if (Auth::user()->hasRole("admin"))
    <li class="menu-title">Administration</li>
    <li>
      <a href="{{ route("lecturers.list") }}">
        <i data-feather="users"></i>
        <span> Lecturers </span>
      </a>
    </li>

    <li>
      <a href="{{ route("students.list") }}">
        <i data-feather="user"></i>
        <span> Students </span>
      </a>
    </li>

    <li>
      <a href="{{ route("projects.list") }}">
        <i data-feather="book"></i>
        <span> Projects </span>
      </a>
    </li>

    <li>
      <a href="{{ route("request.list") }}">
        <i data-feather="git-pull-request"></i>
        <span> Proposals </span>
      </a>
    </li>
  @endif

</ul>
