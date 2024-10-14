@extends('backend.partials.main')
@section('formulaire', 'menu-open')
@section('recap', 'active')
@section('content')

@section('content')

<div class="col-md-12">
    <div class="card">
        <div class="card-header border-0">
          <h3 class="card-title"><center>Situation des formulaires par region</center></h3>
          <div class="card-tools">
            <a href="#" class="btn btn-tool btn-sm">
              <i class="fas fa-download"></i>
            </a>
            <a href="#" class="btn btn-tool btn-sm">
              <i class="fas fa-bars"></i>
            </a>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
              <th>Region</th>
              <th>Nbre Formulaires emis</th>
              <th>Nbre Formulaire recu en production</th>
              <th>Nbre Formulaire recu en recette</th>
            
              <th>Nbre Formulaire restant</th>
              <th>Recette quittance</th>
            
            </tr>
            </thead>
            <tbody>
                @foreach($tab_antenne as $saisie_annee_encour)
            <tr>
                <td>{{$saisie_annee_encour['antenne']}} </td>
                <td> <center>{{$saisie_annee_encour['formulaire_emis']}}</center></td>
                <td><center>{{$saisie_annee_encour['formulaire_recu_prod']}}</center></td>
                <td> <center>{{$saisie_annee_encour['nb_form_quittance']}}</center></td>
                {{-- <td> <center>{{$saisie_annee_encour['rejete']}}</center></td> --}}
                <td> <center>{{$saisie_annee_encour['formulaire_restants']}}</center></td>
                <td><center>{{format_prix($saisie_annee_encour['montant'])}}</center></td>
                <td>
                   
                </td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
    </div>

</div>
<div class="card card-success col-md-12 col-md-offset-2">
    {{-- <button  data-toggle="modal" class="btn btn-success col-md-2" data-target="#create-recette" style="margin-bottom: 7px;"><span></span> Affecter des formulaires</button> --}}

    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Bilan des formulaires par CITD </h3>
    </div>

<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr style="background-color:#0b9e44; color:white">
                    <th>Numero</th>
                    <th>Region</th>
                    <th>CTID</th>
                    <th>Formulaires émis</th>
                    <th>Formulaires enregistrés a la reception des lots</th>
                    <th>Recette</th>
                    <th>Formulaires restant</th>
                    <th>Seuil Min</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @foreach($ctids as $ctid)
                <tr @if($ctid->seuil_min > $ctid->formulaires->sum('nombre') - $ctid->formulaire_recus->sum('nbre_formulaire'))
                         style='color:red';
                    @endif
                    >
                    <td>{{$ctid->id}}</td>
                    <td>{{$ctid->region->libelle}}</td>
                    <td>{{$ctid->libelle}}</td>
                    <td>{{$ctid->formulaires->sum('nombre')}}</td>
                    <td> {{$ctid->formulaire_recus->sum('nbre_formulaire')}}</td>
                    <td>{{format_prix($ctid->recette_quittances->sum('montant'))}}</td>
                    <td>{{$ctid->formulaires->sum('nombre') - $ctid->formulaire_recus->sum('nbre_formulaire')}}</td>
                    <td>{{$ctid->seuil_min}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('detail.quittance_ccd',$ctid) }}"   title="details sur les CCDs" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a> 
                            @can('role.delete',Auth::user())
                            @endcan
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Numero</th>
                <th>Region</th>
                <th>CTID</th>
                <th>Formulaires recus</th>
                <th>Formulaires traités</th>
                <th>Recette</th>
                <th>Formulaires restant</th>
                <th>Seuil Min</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
@section('modalSection')

<div class="modal fade" id="details-ctid">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Details sur le CTID</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}} 
                <div class="row">
                    <div class="col-md-4">
                            <span class="col-md-6">CTID : </label>
                            <span class="col-md-6" > </span>
                         
                    </div>
                    <div class="col-md-4">
                        <span class="col-md-6">CTID : </label>
                        <span class="col-md-6" > </span>
                </div>
                <div class="col-md-4">
                    <span class="col-md-6">CTID : </label>
                    <span class="col-md-6" > </span>
                </div>
                </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('numero_oni') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">1er.serie<span class="text-danger">*</span></label>
                    <input id="premier_serie_u" type="text" class="form-control" name="premier_serie"  placeholder="1er numero de la serie" required autofocus>    
                        @if ($errors->has('premier_serie'))
                        <span class="help-block">
                            <strong>{{ $errors->first('premier_serie') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('numero_oni') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Dernier.numero<span class="text-danger">*</span></label>
                    <input id="dernier_serie_u" type="text" class="form-control" name="dernier_serie"  placeholder="dernier numero de la serie" required autofocus>    
                        @if ($errors->has('dernier_serie'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dernier_serie') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('numero_oni') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Numero trésor<span class="text-danger">*</span></label>
                    <input id="numero_tresor_u" type="text" class="form-control" name="numero_tresor"  placeholder="Entrer le numero ONI" required autofocus>    
                        @if ($errors->has('numero_tresor'))
                        <span class="help-block">
                            <strong>{{ $errors->first('numero_tresor') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>        
        </div> 
        <div class="row">
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nombre de formulaire<span class="text-danger">*</span></label>
                    <input id="nbre_formulaire_u" type="number"  class="form-control" name="nombre_formulaire"  required autofocus>    
                        @if ($errors->has('nombre_formulaire'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre_formulaire') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nombre de rejet<span class="text-danger">*</span></label>
                    <input id="nbre_rejet_u"  type="number"  class="form-control" name="nombre_rejet"  required autofocus>    
                        @if ($errors->has('nombre_rejet'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre_rejet') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Date<span class="text-danger">*</span></label>
                    <input id="date_u" type="text"  class="form-control date_affecte" name="date"  required autofocus>    
                        @if ($errors->has('date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Montant<span class="text-danger">*</span></label>
                    <input id="montant_u" type="text"  class="form-control" name="montant"  required autofocus>    
                        @if ($errors->has('montant'))
                        <span class="help-block">
                            <strong>{{ $errors->first('montant') }}</strong>
                        </span>
                        @endif
                    </div>
            </div> 
        </div> 
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"></i> Enregistrer</button>
        </div> 
        </div>
      
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="create-recette">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Les Saisie de la quittance recette</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('recette_quittance.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Choisir le CCD concerné<span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" id="ctid" name="ccd" data-placeholder="Chosir Region Collecte .." value="{{old("ctid")}}"  required>
                                <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                {{-- @foreach ($ccds as $ccd )
                                        <option value="{{ $ccd->id  }}" {{ old('ccd') == $ccd->id ? 'selected' : '' }}>{{ $ccd->libelle }}</option>
                                @endforeach --}}
                            </select>
                            </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Date Siege<span class="text-danger">*</span></label>
                            <input id="name" type="text"  class="form-control date_affecte" name="date_siege"  required autofocus>    
                                @if ($errors->has('date_affecte'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date_affecte') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('numero_oni') ? ' has-error' : '' }}">
                        <label class=" control-label" for="libelle">Numéro ONI<span class="text-danger">*</span></label>
                        <input id="name" type="text" class="form-control" name="numero_oni"  placeholder="Entrer le numero ONI" required autofocus>    
                            @if ($errors->has('numero_oni'))
                            <span class="help-block">
                                <strong>{{ $errors->first('numero_oni') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('numero_oni') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">1er.serie<span class="text-danger">*</span></label>
                    <input id="name" type="text" class="form-control" name="premier_serie"  placeholder="1er numero de la serie" required autofocus>    
                        @if ($errors->has('premier_serie'))
                        <span class="help-block">
                            <strong>{{ $errors->first('premier_serie') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('numero_oni') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Dernier.numero<span class="text-danger">*</span></label>
                    <input id="name" type="text" class="form-control" name="dernier_serie"  placeholder="dernier numero de la serie" required autofocus>    
                        @if ($errors->has('dernier_serie'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dernier_serie') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('numero_oni') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Numero trésor<span class="text-danger">*</span></label>
                    <input id="name" type="text" class="form-control" name="numero_tresor"  placeholder="Entrer le numero ONI" required autofocus>    
                        @if ($errors->has('numero_tresor'))
                        <span class="help-block">
                            <strong>{{ $errors->first('numero_tresor') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>        
        </div> 
        <div class="row">
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nombre de formulaire<span class="text-danger">*</span></label>
                    <input id="name" type="number"  class="form-control" name="nombre_formulaire"  required autofocus>    
                        @if ($errors->has('nombre_formulaire'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre_formulaire') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nombre de rejet<span class="text-danger">*</span></label>
                    <input  type="number"  class="form-control" name="nombre_rejet"  required autofocus>    
                        @if ($errors->has('nombre_rejet'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre_rejet') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Date<span class="text-danger">*</span></label>
                    <input id="name" type="text"  class="form-control date_affecte" name="date"  required autofocus>    
                        @if ($errors->has('date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Montant<span class="text-danger">*</span></label>
                    <input id="name" type="text"  class="form-control" name="montant"  required autofocus>    
                        @if ($errors->has('montant'))
                        <span class="help-block">
                            <strong>{{ $errors->first('montant') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"></i> Enregistrer</button>
        </div> 
        </form>
        </div>
      
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
    <div id="modal-confirm-delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-pencil"></i> Confirmation</h2>
                    </div>
                    <!-- END Modal Header -->

                    <!-- Modal Body -->
                    <div class="modal-body">
                            <input type="hidden" name="id_table" id="id_table">
                                <p>Voulez-vous vraiment Supprimer ce role ??</p>
                            <div class="form-group form-actions">
                                <div class="text-right">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-sm btn-primary" onclick="supp_id();">OUI</button>
                                </div>
                            </div>

                    </div>
                    <!-- END Modal Body -->
                </div>
            </div>
    </div>
    <script>
      
    </script>
    <script>

    function edit_centre(id){
                var id=id;
                $("#quittance_id").val(id);
            var url = "{{ route('quittance.getById') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        console.log(data)
                        $("#ccd_u").val(data.ccd_id).change();
                        $("#date_siege_u").val(data.date_siege);
                        $("#numero_oni_u").val(data.numero_oni);
                        $("#premier_serie_u").val(data.premier_serie);
                        $("#dernier_serie_u").val(data.dernier_serie);
                        $("#numero_tresor_u").val(data.numero_tresor);
                        $("#nbre_formulaire_u").val(data.nbre_formulaire);
                        $("#nbre_rejet_u").val(data.nbre_rejet);
                        $("#date_u").val(data.date);
                        $("#montant_u").val(data.montant);
                    }
                });
        }
        function idstatus (id){
            var id= id;

            $.ajax({
                url: url,
                type:'GET',
                data: {id: id} ,
                error:function(){alert('error');},
                success:function(){
                }

            });
        }
        function getCentreId(id){
            //alert(id);
            $(function(){
                //alert(id);
                document.getElementById("id_centre").setAttribute("value", id);
            });

        }

        function recu_id(){
            //var id= document.getElementById('id_table').value;
            $(function(){
                var id= $("#id_table").val();

                //alert(id);
                $.ajax({
                    url: url,
                    type:'GET',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(){
                        $('#modal-user-reinitialise').hide();
                        location.reload();

                    }
                });
            });
        }

        function supp_id(){
            $(function(){
                var id= $("#id_table").val();

                //alert(id);
                $.ajax({
                    url: url,
                    type:'GET',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(){
                        $('#modal-confirm-delete').hide();
                        location.reload();

                    }
                });
            });
        }
    </script>

@endsection

