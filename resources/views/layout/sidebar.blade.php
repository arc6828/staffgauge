<!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
 
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">STAFFGAUGE<sup>V1</sup></div>
      </a>
 
      <!-- Divider -->
      <hr class="sidebar-divider" style="display:none">
 
      <!-- Heading -->
      <div class="sidebar-heading">
        Menu
      </div>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/dashboard') }}">
          <i class="fas fa-fw fa-book"></i>
          <span>Dashboard</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/ocr') }}">
          <i class="fas fa-fw fa-image"></i>
          <span>Ocr</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/home') }}">
          <i class="fas fa-fw fa-home"></i>
          <span>Profile</span></a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <!--
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Settings</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Menu</h6>
            <a class="collapse-item" href="{{ url('/home') }}">หน้าหลัก</a>
            <a class="collapse-item" href="{{ url('/ocr') }}">OCR</a>
          </div>
        </div>
      </li>
      -->
 
    </ul>
<!-- End of Sidebar -->