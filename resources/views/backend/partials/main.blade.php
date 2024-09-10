@include('backend.partials.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('title')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Accueil</a></li>
              <li class="breadcrumb-item active">@yield('title')</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">  
        @include('flash-message') 
      @yield('content')
      </div>
    </section>
</div>
<footer class="main-footer">
 <center><strong> Tous droits reservés 2024</a></strong>
  ONI Burkina Faso.</center> 
  <div class="float-right d-none d-sm-inline-block">
    <b></b> 
  </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
@yield('modalSection')
@include('backend.partials.footer')
@yield('add_script')

