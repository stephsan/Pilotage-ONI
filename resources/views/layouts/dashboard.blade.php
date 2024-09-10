@extends('backend.partials.main')
@section('dashboard', 'active')
@section('content')
<div class="block-title">
                    <center><h2><strong>Tableau de Board</strong></h2></center>
                    
</div>
    <!-- Main content -->
    @include('backend.partials.__header_dash')

    @yield('dash_content')
            <!-- /.card -->
            @yield('modal_section')
  @endsection

  
