<!-- Topbar -->
<nav class="navbar navbar-default navbar-expand-lg fixed-top navbar-trans">
    <div class="container">
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <a class="navbar-brand text-brand" href="{{ url('/home') }}">Smart<span class="color-b">Staffgauge</span></a>
      <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-expanded="false">
        <span class="fa fa-search" aria-hidden="true"></span>
      </button>
      <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="{{ url('/dashboard') }}">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/ocr') }}">Ocr</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/location') }}">Location</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/staffgauge') }}">Staffgauge</a>
          </li>
          @if(!Auth::check())
                <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register</a></li>
              @else
                <li class="nav-item">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  @if(Auth::user()->profile->photo)
                    <img src="{{ url('storage') }}/{{Auth::user()->profile->photo}}" width=30 height=30 class="mr-2 rounded-circle">
                  @endif
                  {{ Auth::user()->name }}<span class="caret"></span>
                  </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{url('/home')}}"">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ url('/logout') }}"
                  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                  </a>
                  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>
            @endif
        </ul>
      </div>
    </nav>
<!-- End of Topbar -->