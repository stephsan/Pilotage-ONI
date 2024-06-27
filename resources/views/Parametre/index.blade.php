@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('administration-parametre', 'active')
@section('content')

<div class="block-title">
    <center><h2><strong>Liste des Paramètres</strong></h2></center>                    
</div>

<div class="card">                           
              <!-- /.card-header -->
              <div class="card-body">
                <a href="{{ route('parametre.create') }}" class="btn btn-block btn-success col-md-2 mt-2" type="button"><span><i class="fa fa-plus"></i></span>Parametre</a>

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr style="background-color:#0b9e44; color:white">
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Description</th> 
                    <th>Action</th>                   
                  </tr>
                  </thead>
                  <tbody>
                  @php
                        $i=0; 
                    @endphp
                    @foreach ($parametres as $parametre)
                            @php
                            $i++;
                            @endphp
                  <tr>    
                    <td>{{$i}}</td> 
                    <td>{{$parametre->libelle}}</td> 
                    <td>{{$parametre->description}}</td>                              
                    <td><a href="#" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a>
                       <a href="{{ route('parametre.edit',$parametre) }}" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-default"><i class="fa fa-pen"></i></a>                  

                    </td>  
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>N°</th>
                    <th>Nom</th>
                    <th>Description</th> 
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
    </div>

@endsection