<!DOCTYPE html>
<html lang="en">
 
<head>
 
  @include('layout.head')
 
</head>
 
<body id="page-top">
  
  @include('layout.js')
  
  <!-- Page Wrapper -->
  <div class="wrapper">
 
    <!-- Content Wrapper -->
    <div class="wrapper">
 
      <!-- Main Content -->
      <div class="container-fluid">
 
          @include('layout.navbar')
 
        <!-- Begin Page Content -->
        <section class="section-services section-t8">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>
    </div>
  </section>
 
            @yield('content')
 
        </div>
        <!-- /.container-fluid -->
 
      </div>
      <!-- End of Main Content -->
 
      @include('layout.footer')
      </div>
 
    </div>
    <!-- End of Content Wrapper -->
 
  </div>
  <!-- End of Page Wrapper -->
 
    
</body>
 
</html>