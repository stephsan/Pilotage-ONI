@extends('backend.partials.main')
@section('recette', 'menu-open')
@section('recette-saisie', 'active')
@section('content')

@section('content')
<div class="card card-success col-md-12 col-md-offset-2">
    <div class="row">
    @can('recette.create', Auth::user()) 
        <button  data-toggle="modal" class="btn btn-success col-md-2 pull-right mt-2" style="margin-bottom: 7px;" data-target="#create-centre"><span></span> Enregistrer les recettes</button>
    @endcan
        {{-- <button  onclick="deselectionner();" class="btn btn-success col-md-2  pull-right mt-2" style="margin-left: 10px; margin-bottom: 7px;"><span></i></span>Supprimer</button> --}}
     @can('recette.valider', Auth::user()) 
        <button  onclick="valider();" class="btn btn-danger col-md-2  pull-right mt-2" style=" margin-left: 10px; margin-bottom: 7px;" ><span></i></span>Valider les saisies</button>
    @endcan
    </div>
    
    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Liste des recettes</h3>
    </div>

<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>Cocher</th>
                    <th>Numéro</th>
                    <th>Date</th>
                    <th>Nature</th>
                    <th>Montant</th>
                    <th>Degagement</th>
                    <th>Solde</th>
                    <th>Observations</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
                @php
                    $i=0;
                @endphp
            @foreach($recettes as $recette)
                    @php
                    $i++;
                @endphp
                <tr @if($recette->statut==1)
                        style="color:green;"
                    @else
                        style="color:red;"
                    @endif>
                    <td>
                        <input type="checkbox" name="" id="{{ $recette->id }}" value="{{ $recette->id }}">
                    </td>
                    <td>{{$i}}</td>
                    <td>{{$recette->date_saisie}}</td>
                    <td>{{getlibelle($recette->type_recette)}}</td>
                    <td>{{format_prix($recette->montant)}}</td>
                    <td>{{$recette->degagement}}</td>
                    <td>{{$recette->solde}}</td>
                    <td>{{$recette->observation}}</td>
                    
                    <td class="text-center">
                            <div class="btn-group">
                            @can('recette.update', Auth::user()) 
                                @if($recette->statut == 0)
                                    <button  data-toggle="modal" onclick="edit_recette({{ $recette->id }});"  data-toggle="tooltip" title="Modifier" class="btn btn-xs btn-default" data-target="#update-centre" ><i class="fa fa-edit"></i></a>
                                @endif
                            @endcan
                            {{-- @can('role.delete',Auth::user())
                                <a href="#modal-confirm-delete" onclick="delConfirm({{ $recette->id }});" data-toggle="modal" title="Annuler la recette" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                            @endcan --}}
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Cocher</th>
                <th>Numéro</th>
                <th>Date</th>
                <th>Nature</th>
                <th>Montant</th>
                <th>Degagement</th>
                <th>Solde</th>
                <th>Observations</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
</div>
@endsection
@section('modalSection')

<div class="modal fade" id="update-centre">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modifier une recette</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('recette.modifier') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="recette_id" name="recette_id">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="region">Nature recette<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" name="nature" id="nature_u" data-placeholder="Selectionnez la nature de la recette.."  onchange="cacherSiValnatureRecette('nature_u','champ_cnib','autre_champ')" required>
                                    <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                    @foreach ($nature_recettes as $nature )
                                            <option value="{{ $nature->id  }}" {{ old('ccd') == $nature->id ? 'selected' : '' }}>{{ $nature->libelle }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6 champ_cnib">
                        <div class="form-group">
                            <label class="control-label" for="region">Site d'opération<span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" id="site_u" name="site" data-placeholder="Chosir le site doperation .." value="{{old("site")}}" >
                                <option></option>
                                @foreach ($ccds as $ccd )
                                        <option value="{{ $ccd->id }}" {{ old('ccd') == $ccd->id ? 'selected' : '' }}>{{ $ccd->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 autre_champ" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Denomination de la personne(physique ou morale) : <span class="text-danger">*</span></label>
                            <input id="denomination_u" type="text"  class="form-control" name="denomination" >    
                                @if ($errors->has('denomination'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('denomination') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Montant : <span class="text-danger">*</span></label>
                            <input id="montant_u" type="text"  class="form-control" name="montant"  required autofocus>    
                                @if ($errors->has('montant'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('montant') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-6 autre_champ"  >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Date de paiement<span class="text-danger">*</span></label>
                            <input id="date_de_paiement_u" type="text"  class="form-control date_affecte" name="date_de_paiement" >    
                                @if ($errors->has('date_de_paiement'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date_de_paiement') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                   
                </div> 

        <div class="row">
            <div class="col-md-6 autre_champ">
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Motif : <span class="text-danger">*</span></label>
                    <input id="motif_u" type="text"  class="form-control" name="motif">    
                        @if ($errors->has('motif'))
                        <span class="help-block">
                            <strong>{{ $errors->first('motif') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Observations</label>
                <textarea class="form-control" id="observation_u" name="observation" rows="3" placeholder="Entrer une description du centre de collecte ..." required></textarea>
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
          <h4 class="modal-title">Enregistrer une recette</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('recette.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="region">Nature recette<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" name="nature" id="nature" data-placeholder="Selectionnez la nature de la recette.."  onchange="cacherSiValnatureRecette('nature','champ_cnib','autre_champ')" required>
                                    <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                    @foreach ($nature_recettes as $nature )
                                            <option value="{{ $nature->id  }}" {{ old('ccd') == $nature->id ? 'selected' : '' }}>{{ $nature->libelle }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6 champ_cnib">
                        <div class="form-group">
                            <label class="control-label" for="region">Site d'opération<span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" id="site" name="site" data-placeholder="Chosir le site doperation .." value="{{old("site")}}" >
                                <option></option>
                                @foreach ($ccds as $ccd )
                                        <option value="{{ $ccd->id }}" {{ old('ccd') == $ccd->id ? 'selected' : '' }}>{{ $ccd->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 autre_champ" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Denomination de la personne(physique ou morale) : <span class="text-danger">*</span></label>
                            <input id="denomination" type="text"  class="form-control" name="denomination" >    
                                @if ($errors->has('montant'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('montant') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Montant : <span class="text-danger">*</span></label>
                            <input id="montant" type="text"  class="form-control" name="montant"  required autofocus>    
                                @if ($errors->has('montant'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('montant') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-6 autre_champ"  >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Date de paiement<span class="text-danger">*</span></label>
                            <input id="date_de_paiement" type="text"  class="form-control date_affecte" name="date_de_paiement" >    
                                @if ($errors->has('date_de_paiement'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date_de_paiement') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                   
                </div> 

        <div class="row">
            <div class="col-md-6 autre_champ">
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Motif : <span class="text-danger">*</span></label>
                    <input id="motif" type="text"  class="form-control" name="motif">    
                        @if ($errors->has('motif'))
                        <span class="help-block">
                            <strong>{{ $errors->first('motif') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Observations</label>
                <textarea class="form-control" id="observation" name="observation" rows="3" placeholder="Entrer une description du centre de collecte ..." required></textarea>
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
function valider(){
        var recettes=[];
       // var formation = $("#formation").val();
        $('#example1 :input:checkbox:checked').each(function(){
        recettes.push($(this).val());
    });
        var url = "{{ route('recette.valider') }}";
    $.ajax({
        url: url,
        type:'GET',
        data: { recettes: recettes } ,
        error:function(){alert('error');},
        success:function(){
            $('#example1').find('input').attr('checked', false);
            location.reload();
        }
    });
    }
    function cacherSiValnatureRecette(natureRecette,champcnib,champAutre){
        var naturere=$('#'+natureRecette).val();
        if(naturere==9){
            $('.'+champcnib).show();
            $('.'+champAutre).hide();
        }
        else{
            $('.'+champcnib).hide();
            $('.'+champAutre).show();
        }

    }

    function edit_recette(id){
                var id=id;
                
                $('#site_u').prop('selectedIndex',0);
                $("#nature_u").val('');
                $("#montant_u").val('');
                $("#observation_u").val('');
                $("#description_u").val('');
              //  alert(id);
                 //var centre_id= $("#edit_centre").val();
            var url = "{{ route('recette.getById') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        $('#site_u').val(data.site_operation).change();;
                        $("#nature_u").val(data.type_recette).change();;
                        $("#montant_u").val(data.montant);
                        $("#denomination_u").val(data.nom_complet_dela_personne);
                        $("#motif_u").val(data.motif);
                        $("#date_de_paiement_u").val(data.date_de_paiement);
                        $("#observation_u").val(data.observation);
                        $("#recette_id").val(data.id);
                        
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

