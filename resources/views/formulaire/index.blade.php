@extends('backend.partials.main')
@section('formulaire', 'menu-open')
@section('affectation', 'active')
@section('content')

@section('content')
<div class="card card-success col-md-12 col-md-offset-2">
 @can('formulaire.create', Auth::user()) 
    <button  data-toggle="modal" class="btn btn-success col-md-2" data-target="#create-centre" style="margin-bottom: 7px;"><span></span> Affecter des formulaires</button>
@endcan
    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Situation des formulaires affectés aux CTID</h3>
    </div>

<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr style="background-color:#0b9e44; color:white">
                    <th>Numero</th>
                    <th>Antenne</th>
                    <th>Ctid</th>                  
                    <th>1er Serie</th>
                    <th>Dernier Serie</th>
                    <th>Quantite</th>
                    <th>Date d'émission</th>
                    <th>Date de transmission</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @foreach($formulaires as $formulaire)
                <tr>
                    <td>{{$formulaire->id}}</td>
                    <td>{{$formulaire->ctid->antenne->nom_de_lantenne}}</td>
                    <td>{{$formulaire->ctid->libelle}}</td>
                    <td>{{$formulaire->premier_serie}}</td>
                    <td>{{$formulaire->dernier_serie}}</td>
                    <td>{{$formulaire->nombre}}</td>
                    <td>{{format_date($formulaire->date_emission)}}</td>
                    <td>{{format_date($formulaire->date_fourniture)}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                            
                                <button  data-toggle="modal" onclick="edit_centre({{ $formulaire->id }});"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" data-target="#update-centre" ><i class="fa fa-edit"></i></a>
                            {{-- @endcan --}}
                            @can('role.delete',Auth::user())
                                <a href="#modal-confirm-delete" onclick="delConfirm({{ $formulaire->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                            @endcan
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Numero</th>
                <th>Antenne</th>
                <th>Ctid</th>                  
                <th>1er Serie</th>
                <th>Dernier Serie</th>
                <th>Quantite</th>
                <th>Date d'émission</th>
                <th>Date de transmission</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
@section('modalSection')

<div class="modal fade" id="update-centre">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modifier un centre de collecte</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('formulaire_prod.modifier') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="formulaire_id" name="formulaire_id">
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}} 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Antenne<span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" id="antenne_u" name="antenne" data-placeholder="Chosir l'antenne concernée.." value="{{old("ctid")}}" onchange="getCitds('antenne_u', 'ctid_u');" required>
                                <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                @foreach ($antennes as $antenne )
                                        <option value="{{ $antenne->id  }}" {{ old('ctid') == $antenne->id ? 'selected' : '' }}>{{ $antenne->nom_de_lantenne }}</option>
                                @endforeach
                            </select>
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Choisir le CTID concerné<span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" id="ctid_u" name="ctid" data-placeholder="Chosir Region Collecte .." value="{{old("ctid")}}"  required>
                                <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                @foreach ($ctids as $ctid )
                                        <option value="{{ $ctid->id  }}" {{ old('ctid') == $ctid->id ? 'selected' : '' }}>{{ $ctid->libelle }}</option>
                                @endforeach
                            </select>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group{{ $errors->has('premier_serie') ? ' has-error' : '' }}">
                            <label class=" control-label" for="premier_serie">1er Numéro serie<span class="text-danger">*</span></label>
                            <input id="premier_serie_u" type="number" class="form-control" name="premier_serie"  placeholder="Entrer le nom du centre de collecte" required autofocus>    
                                @if ($errors->has('premier_serie'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('premier_serie') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group{{ $errors->has('dernier_serie') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Dernier numéro série<span class="text-danger">*</span></label>
                            <input id="dernier_serie_u" type="number" class="form-control" name="dernier_serie"  placeholder="Entrer le nom du centre de collecte" required autofocus>    
                                @if ($errors->has('dernier_serie'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dernier_serie') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group{{ $errors->has('quantite') ? ' has-error' : '' }}">
                            <label class=" control-label" for="quantite">Quantité<span class="text-danger">*</span></label>
                            <input id="quantite_u" type="number" class="form-control" name="quantite"  placeholder="Nombre de formulaire" required autofocus>    
                                @if ($errors->has('quantite'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('quantite') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                    
        <div class="row">
            <div class="col-md-6" >
            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                <label class=" control-label" for="libelle">Date d'émission<span class="text-danger">*</span></label>
                <input id="date_emission_u" type="text"  class="form-control date_affecte" name="date_emission"  required autofocus>    
                    @if ($errors->has('date_affecte'))
                    <span class="help-block">
                        <strong>{{ $errors->first('date_affecte') }}</strong>
                    </span>
                    @endif
                </div>
             </div>
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Date de transmission<span class="text-danger">*</span></label>
                    <input id="date_affect_u" type="text"  class="form-control date_affecte" name="date_affecte"  required autofocus>    
                        @if ($errors->has('date_affecte'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_affecte') }}</strong>
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
  <div class="modal fade" id="create-centre">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Affecter les formulaires</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('formulaire_prod.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Antenne<span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" id="antenne" name="antenne" data-placeholder="Chosir l'antenne concernée.." value="{{old("ctid")}}"   onchange="getCitds('antenne', 'ctid');"  required>
                                <option></option>
                                @foreach ($antennes as $antenne )
                                        <option value="{{ $antenne->id  }}" {{ old('ctid') == $antenne->id ? 'selected' : '' }}>{{ $antenne->nom_de_lantenne }}</option>
                                @endforeach
                            </select>
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Choisir le CTID concerné<span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" id="ctid" name="ctid" data-placeholder="Chosir Region Collecte .." value="{{old("ctid")}}" required>
                                <option></option>
                                @foreach ($ctids as $ctid )
                                        <option value="{{ $ctid->id  }}" {{ old('ctid') == $ctid->id ? 'selected' : '' }}>{{ $ctid->libelle }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group{{ $errors->has('premier_serie') ? ' has-error' : '' }}">
                            <label class=" control-label" for="premier_serie">1er Numéro serie<span class="text-danger">*</span></label>
                            <input id="premier_serie" type="number" class="form-control" name="premier_serie"  placeholder="Entrer le nom du centre de collecte" required autofocus>    
                                @if ($errors->has('premier_serie'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('premier_serie') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group{{ $errors->has('dernier_serie') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Dernier numéro série<span class="text-danger">*</span></label>
                            <input id="dernier_serie" type="number" class="form-control" name="dernier_serie"  placeholder="Entrer le nom du centre de collecte" required autofocus>    
                                @if ($errors->has('dernier_serie'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dernier_serie') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group{{ $errors->has('quantite') ? ' has-error' : '' }}">
                            <label class=" control-label" for="quantite">Quantité<span class="text-danger">*</span></label>
                            <input id="quantite" type="number" class="form-control" name="quantite"  placeholder="Nombre de formulaire" required autofocus>    
                                @if ($errors->has('quantite'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('quantite') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
        <div class="row">
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Date d'émission<span class="text-danger">*</span></label>
                    <input id="date_emission" type="text"  class="form-control date_affecte" name="date_emission"  required autofocus>    
                        @if ($errors->has('date_affecte'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_affecte') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Date de l'affectation<span class="text-danger">*</span></label>
                    <input id="create-centre" type="text"  class="form-control date_affecte" name="date_affecte"  required autofocus>    
                        @if ($errors->has('date_affecte'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_affecte') }}</strong>
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
    </div>
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
                $("#formulaire_id").val(id);
            var url = "{{ route('formulaire_prod.getById') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        console.log(data)
                        $("#ctid_u").val(data.centre_traitement_id).change();
                        $("#quantite_u").val(data.nombre);
                        $("#date_affect_u").val(data.date_fourniture);
                        $("#dernier_serie_u").val(data.dernier_serie);
                        $("#premier_serie_u").val(data.premier_serie);
                        $("#date_emission_u").val(data.date_emission);
                        $("#quantite_u").val(data.nombre);

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

