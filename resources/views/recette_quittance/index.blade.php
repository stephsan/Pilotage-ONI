@extends('backend.partials.main')
@section('formulaire', 'menu-open')
@section('saisie', 'active')
@section('content')

@section('content')
<div class="card card-success col-md-12 col-md-offset-2">
    {{-- <button  data-toggle="modal" class="btn btn-success col-md-2" data-target="#create-recette" style="margin-bottom: 7px;"><span></span> Nouvelle quittance recette</button> --}}

    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Situation des quittance recette </h3>
    </div>

<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr style="background-color:#0b9e44; color:white">
                    <th>Numero</th>
                    <th>Région</th>
                    <th>CTID</th>
                    <th>CCD</th>

                    <th>Numero Tresor</th>
                    <th>Date</th>
                    {{-- <th>Valeur formulaire</th> --}}
                    <th>Nombre formulaire</th>
                    <th>Nombre rejeté</th>
                    <th>Montant</th>
                    <th>Actions</th>
                    <th>Date Siége</th>
                    <th>Numéro ONI</th>
                    <th>1er Serie</th>
                    <th>Dernier Serie</th>
                   
                </tr>
        </thead>
        <tbody>
            @foreach($recette_quittances as $recette_quittance)
                <tr>
                    <td>{{$recette_quittance->id}}</td>
                    <td>{{$recette_quittance->ctid->region->libelle}}</td>
                    <td>{{$recette_quittance->ctid->libelle}}</td>
                    <td>{{$recette_quittance->ccd->libelle}}</td>
                    <td>{{$recette_quittance->numero_tresor}}</td>
                    <td>{{$recette_quittance->date}}</td>
                    <td>{{$recette_quittance->nbre_formulaire}}</td>
                    <td>{{$recette_quittance->nbre_rejet}}</td>
                    <td>{{format_prix($recette_quittance->montant)}}</td>
                    <td class="text-center">
                        <div class="btn-group">
                         {{-- @can('role.update', Auth::user()) --}}
                         @if(!recette_is_validate($recette_quittance->id))
                            <button  data-toggle="modal" onclick="edit_recette_quittance({{ $recette_quittance->id }});"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" data-target="#update-centre" ><i class="fa fa-edit"></i></a>
                        @endif
                        {{-- @endcan --}}
                        @can('role.delete',Auth::user())
                            <a href="#modal-confirm-delete" onclick="delConfirm({{ $recette_quittance->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                        @endcan
                        </div>
                    </td>
                    <td>{{format_date($recette_quittance->date_siege)}}</td>
                    <td>{{$recette_quittance->numero_oni}}</td>
                    <td>{{$recette_quittance->premier_serie}}</td>
                    <td>{{$recette_quittance->dernier_serie}}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Numero</th>
                <th>Région</th>
                <th>CTID</th>
                <th>CCD</th>
                <th>Numero Tresor</th>
                <th>Date</th>
                {{-- <th>Valeur formulaire</th> --}}
                <th>Nombre formulaire</th>
                <th>Nombre rejeté</th>
                <th>Montant</th>
                <th>Actions</th>
                <th>Date Siége</th>
                <th>Numéro ONI</th>
                <th>1er Serie</th>
                <th>Dernier Serie</th>
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
          <h4 class="modal-title">Modifier la saisie de la quittance recette</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('quittance.modifier') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="quittance_id" name="quittance_id">
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}} 

                <div class="row">
                    <div class="col-md-6" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Numero de lot<span class="text-danger">*</span></label>
                            <input id="num_lot" type="text"  class="form-control" name="num_lot" readonly='true' required autofocus>    
                                @if ($errors->has('num_lot'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('num_lot') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-6" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Montant<span class="text-danger">*</span></label>
                            <input id="montant_u" type="text"  class="form-control" name="montant"  readonly='true' required autofocus>    
                                @if ($errors->has('montant'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('montant') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">CCD concerné<span class="text-danger">*</span></label>
                            <input id="ccd_libelle_u" type="text" class="form-control" name="ccd" readonly="true" required autofocus>    
                            </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Date Siege<span class="text-danger">*</span></label>
                            <input id="date_siege_u" type="text"  class="form-control date_affecte" name="date_siege"  required autofocus>    
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
                        <input id="numero_oni_u" type="text" class="form-control" name="numero_oni"  placeholder="Entrer le numero ONI" required autofocus>    
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
                    <input id="premier_serie_u" type="text" class="form-control" name="premier_serie" readonly='true' placeholder="1er numero de la serie" required autofocus>    
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
                    <input id="dernier_serie_u" type="text" class="form-control" name="dernier_serie"  placeholder="dernier numero de la serie" readonly='true' required autofocus>    
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
            <div class="col-md-4" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Valeur du formulaire<span class="text-danger">*</span></label>
                    <input id="valeur_form_u" type="text"  class="form-control" name="valeur_form" readonly='true'  required autofocus>    
                        @if ($errors->has('valeur_form'))
                        <span class="help-block">
                            <strong>{{ $errors->first('valeur_form') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nombre de formulaire<span class="text-danger">*</span></label>
                    <input id="nbre_formulaire_u" type="number"  class="form-control" name="nombre_formulaire" onchange="verifierSaisiequittance('ccd_u','nombre_formulaire_u','modification');"  readonly="true"  required autofocus>    
                        @if ($errors->has('nombre_formulaire'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre_formulaire') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nombre de rejet<span class="text-danger">*</span></label>
                    <input id="nbre_rejet_u"  type="number"  class="form-control" name="nombre_rejet" onchange="setMontantRecette('valeur_form_u','nbre_formulaire_u','nbre_rejet_u','montant_u')" required autofocus>    
                        @if ($errors->has('nombre_rejet'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre_rejet') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
        </div> 
        <div class="row">
            
             
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
  {{-- <div class="modal fade" id="create-recette">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"> Nouvelle saisie de la quittance recette</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('recette_quittance.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}               
                
                <div class="row">
                    <p style="background-color: #d56d72; display:none; text-align:center" class="message_verification_saisie_nombre col-md-8 col-md-offset-3"> Attention vous ne pouvez pas saisir ce nombre de formulaire pour ce CTID !!! Consulter le recap des formulaires</p>
                </div>
                <div class="row">
                    <div class="col-md-6" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Numero de lot<span class="text-danger">*</span></label>
                            <input id="num_lot" type="text"  class="form-control" name="num_lot" readonly='true'  required autofocus>    
                                @if ($errors->has('num_lot'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('num_lot') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-6" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Montant<span class="text-danger">*</span></label>
                            <input id="montant" type="text"  class="form-control" name="montant"  required autofocus>    
                                @if ($errors->has('montant'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('montant') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Choisir le CCD concerné<span class="text-danger">*</span></label>
                            <select id="ccd" class="form-control select2" style="width: 100%;" id="ctid" name="ccd" data-placeholder="Chosir le CCD .." value="{{old("ccd")}}"  required>
                                <option></option>
                                @foreach ($ccds as $ccd )
                                        <option value="{{ $ccd->id  }}" {{ old('ccd') == $ccd->id ? 'selected' : '' }}>{{ $ccd->libelle }}</option>
                                @endforeach
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
                        <input id="numero_oni" type="text" class="form-control" name="numero_oni"  placeholder="Entrer le numero ONI" required autofocus>    
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
                    <input id="premier_serie" type="text" class="form-control" name="premier_serie"  placeholder="1er numero de la serie" required autofocus>    
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
                    <input id="dernier_serie" type="text" class="form-control" name="dernier_serie"  placeholder="dernier numero de la serie" required autofocus>    
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
                    <input id="numero_tresor" type="text" class="form-control" name="numero_tresor"  placeholder="Entrer le numero ONI" required autofocus>    
                        @if ($errors->has('numero_tresor'))
                        <span class="help-block">
                            <strong>{{ $errors->first('numero_tresor') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>        
        </div> 
       
        <div class="row">
            <div class="col-md-4" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Valeur du formulaire<span class="text-danger">*</span></label>
                    <input id="valeur_form" type="text" class="form-control" name="valeur_form" value="2500" required autofocus>    
                        @if ($errors->has('valeur_form'))
                        <span class="help-block">
                            <strong>{{ $errors->first('valeur_form') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nombre de formulaire<span class="text-danger">*</span></label>
                    <input id="nombre_formulaire" type="number" class="form-control" name="nombre_formulaire" onchange="verifierSaisiequittance('ccd','nombre_formulaire','creation');"  required autofocus>    
                        @if ($errors->has('nombre_formulaire'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre_formulaire') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nombre de rejet<span class="text-danger">*</span></label>
                    <input  id="nombre_rejet" type="number"  class="form-control" name="nombre_rejet" onchange="setMontantRecette()" required autofocus>    
                        @if ($errors->has('nombre_rejet'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre_rejet') }}</strong>
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

  </div> --}}
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

function setMontantRecette(valeur_formulaire, nbre_formulaire,nbre_rejet,montant){
    //alert('ok');
        var valeur_formulaire= $('#'+valeur_formulaire).val()
        var nbre_formulaire= $('#'+nbre_formulaire).val()
        var nbre_rejet= $('#'+nbre_rejet).val()
        var valeur= (parseInt(nbre_formulaire) - parseInt(nbre_rejet)) * valeur_formulaire;
        $('#'+montant).val(valeur);
}
    function edit_recette_quittance(id){
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
                        $("#ccd_libelle_u").val(data.ccd_libelle);
                        $("#valeur_form_u").val(data.montant_formulaire);
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

