@extends('backend.partials.main')
@section('statistique', 'menu-open')
@section('registre', 'active')
@section('content')

@section('content')
<div class="card card-success col-md-12 col-md-offset-2">
    @can('enregistrer_dans_le_registre',Auth::user())
        <button  data-toggle="modal" class="btn btn-success col-md-2 pull-right mt-2" style="margin-bottom: 7px;" data-target="#create-registre"><span></span> Ajouter une ligne</button>
    @endcan

    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Registre</h3>
    </div>

<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>Numero</th>
                    <th>Date</th>
                    <th>Effectif Theorique</th>
                    <th>Effectif présent</th>
                    <th>En conge</th>
                    <th>En mission</th>
                    <th>Absent</th>
                    <th>Malade</th>
                    <th>Nbre de photos investigués</th>
                    <th>Enrolées manuellement</th>
                    <th>En attente de tirage</th>
                    <th>En attente d'investigation</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @foreach($registres as $registre)
                <tr>
                    <td>{{$registre->id}}</td>
                    <td>{{$registre->date_effet}}</td>
                    <td>{{$registre->effectif_theorique}}</td>
                    <td>{{$registre->effectif_present}}</td>
                    <td>{{$registre->effectif_conge}}</td>
                    <td>{{$registre->effectif_mission}}</td>
                    <td>{{$registre->effectif_absent}}</td>
                    <td>{{$registre->effectif_malade}}</td>
                    <td>{{$registre->nbre_photo_investigues}}</td>
                    <td>{{$registre->nbre_photo_enrole_manuellement}}</td>
                    <td>{{$registre->nbre_photo_en_attente_de_tirage}}</td>
                    <td>{{$registre->nbre_photo_en_attente_dinvestigation}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                             @can('modifier_le_registre',Auth::user())
                                <button  data-toggle="modal" onclick="edit_registre({{ $registre->id }});"  data-toggle="tooltip" title="Modifier" class="btn btn-xs btn-default" data-target="#update-registre" ><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('role.delete',Auth::user())
                                <a href="#modal-confirm-delete" onclick="delConfirm({{ $registre->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                            @endcan
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Numero</th>
                    <th>Date</th>
                    <th>Effectif Theorique</th>
                    <th>Effectif présent</th>
                    <th>En conge</th>
                    <th>En mission</th>
                    <th>Absent</th>
                    <th>Malade</th>
                    <th>Nbre de photos investigués</th>
                    <th>Enrolées manuellement</th>
                    <th>En attente de tirage</th>
                    <th>En attente d'investigation</th>
                    <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
        </div>
@endsection
@section('modalSection')
<div class="modal fade" id="update-registre">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modifier une entite</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('registre.modifier') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="id_registre" name="registre_id">
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}} 
                <div class="row">
                    <div class="col-md-8" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Date concernée<span class="text-danger">*</span></label>
                            <input id="date_effet_u" type="text"  class="form-control date_affecte" name="date_effet"  required autofocus>    
                                @if ($errors->has('date_effet'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date_effet') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
               <fieldset>
                    <legend>Effectif du jour</legend>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('eff_theorique') ? ' has-error' : '' }}">
                                <label class=" control-label" for="eff_theorique">Effectif Théorique<span class="text-danger">*</span></label>
                                <input id="eff_theorique_u" type="number"  class="form-control" name="eff_theorique" min="0" placeholder="Entrer effectif theorique" required autofocus>    
                                    @if ($errors->has('eff_theorique'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('eff_theorique') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('eff_present') ? ' has-error' : '' }}">
                                <label class=" control-label" for="eff_present">Effectif présent<span class="text-danger">*</span></label>
                                <input id="eff_present_u" type="number"  class="form-control" name="eff_present" min="0" placeholder="Entrer effectif présent" required autofocus>    
                                    @if ($errors->has('eff_present'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('eff_present') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('eff_absent') ? ' has-error' : '' }}">
                                <label class=" control-label" for="eff_absent">Effectif absent<span class="text-danger">*</span></label>
                                <input id="eff_absent_u" type="number"  class="form-control" name="eff_absent" min="0" placeholder="Entrer effectif absent" required autofocus>    
                                    @if ($errors->has('eff_absent'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('eff_absent') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group{{ $errors->has('eff_conge') ? ' has-error' : '' }}">
                                <label class=" control-label" for="eff_conge">Effectif en congé<span class="text-danger">*</span></label>
                                <input id="eff_conge_u" type="number"  class="form-control" name="eff_conge" min="0" placeholder="Entrer effectif en congé" required autofocus>    
                                    @if ($errors->has('eff_conge'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('eff_conge') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group{{ $errors->has('eff_permission') ? ' has-error' : '' }}">
                                <label class=" control-label" for="eff_permission">Effectif en permission<span class="text-danger">*</span></label>
                                <input id="eff_permission_u" type="number"  class="form-control" name="eff_permission" min="0" placeholder="Entrer effectif en permission" required autofocus>    
                                    @if ($errors->has('eff_permission'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('eff_permission') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group{{ $errors->has('eff_mission') ? ' has-error' : '' }}">
                                <label class=" control-label" for="eff_mission">Effectif en mission<span class="text-danger">*</span></label>
                                <input id="eff_mission_u" type="number"  class="form-control" name="eff_mission" min="0" placeholder="Entrer effectif en mission" required autofocus>    
                                    @if ($errors->has('eff_mission'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('eff_mission') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group{{ $errors->has('eff_maladie') ? ' has-error' : '' }}">
                                <label class=" control-label" for="eff_maladie">Effectif malade<span class="text-danger">*</span></label>
                                <input id="eff_maladie_u" type="number"  class="form-control" name="eff_maladie" min="0" placeholder="Entrer effectif malade" required autofocus>    
                                    @if ($errors->has('eff_maladie'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('eff_maladie') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                    </div>
               </fieldset>
               <hr>
               <fieldset>
                <legend>Statistique du jour</legend>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photos_a_verifier') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photos_a_verifier">Nbre de photos a verifier<span class="text-danger">*</span></label>
                            <input id="nbre_photos_a_verifier_u" type="number"  class="form-control" name="nbre_photos_a_verifier" min="0" placeholder="Entrer nombre de photos a verifier" required autofocus>    
                                @if ($errors->has('nbre_photos_a_verifier'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photos_a_verifier') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photo_enrole_manuellement') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photo_enrole_manuellement">Nbre de photos enrolées manuellement<span class="text-danger">*</span></label>
                            <input id="nbre_photo_enrole_manuellement_u" type="number"  class="form-control" name="nbre_photo_enrole_manuellement" min="0" placeholder="Entrer nombre de photos enrolées manuellement" required autofocus>    
                                @if ($errors->has('nbre_photo_enrole_manuellement'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photo_enrole_manuellement') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photo_triees') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photo_triees">Nbre de photos triées<span class="text-danger">*</span></label>
                            <input id="nbre_photo_triees_u" type="number"  class="form-control" name="nbre_photo_triees" min="0" placeholder="Entrer de photo triées" required autofocus>    
                                @if ($errors->has('nbre_photo_triees'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photo_triees') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photo_investigues') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photo_investigues">Nbre de photos investiguées<span class="text-danger">*</span></label>
                            <input id="nbre_photo_investigues_u" type="number"  class="form-control" name="nbre_photo_investigues" min="0" placeholder="Entrer nombre de photos investigués" required autofocus>    
                                @if ($errors->has('nbre_photo_investigues'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photo_investigues') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photo_en_attente_de_tirage') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photo_en_attente_de_tirage">Nbre de photos en attente de tirage<span class="text-danger">*</span></label>
                            <input id="nbre_photo_en_attente_de_tirage_u" type="number"  class="form-control" name="nbre_photo_en_attente_de_tirage" min="0" placeholder="Nombre de photo en attente de tirage" required autofocus>    
                                @if ($errors->has('nbre_photo_en_attente_de_tirage'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photo_en_attente_de_tirage') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photo_en_attente_dinvestigation') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photo_en_attente_dinvestigation">Nbre de photo en attente d'investigation<span class="text-danger">*</span></label>
                            <input id="nbre_photo_en_attente_dinvestigation_u" type="number"  class="form-control" name="nbre_photo_en_attente_dinvestigation" min="0" placeholder="Entrer nombre de photo en attente d'investigation" required autofocus>    
                                @if ($errors->has('nbre_photo_en_attente_dinvestigation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photo_en_attente_dinvestigation') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photo_cas_fraude') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photo_cas_fraude">Nbre de photo en cas de fraude<span class="text-danger">*</span></label>
                            <input id="nbre_photo_cas_fraude_u" type="number"  class="form-control" name="nbre_photo_cas_fraude" min="0" placeholder="Entrer nombre de photo cas de fraude" required autofocus>    
                                @if ($errors->has('nbre_photo_cas_fraude'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photo_cas_fraude') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
           </fieldset>
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
  <div class="modal fade" id="create-registre">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Registe</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('registre.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-8" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Date concernée<span class="text-danger">*</span></label>
                            <input id="date_effet" type="text"  class="form-control date_affecte" name="date_effet"  required autofocus>    
                                @if ($errors->has('date_effet'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date_effet') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                @include('backend.partials._header_registre_stat')
               <hr>
               <fieldset>
                <legend>Statistique du jour</legend>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photos_a_verifier') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photos_a_verifier">Nbre de photos a verifier<span class="text-danger">*</span></label>
                            <input id="nbre_photos_a_verifier" type="number"  class="form-control" name="nbre_photos_a_verifier" min="0" placeholder="Entrer nombre de photos a verifier" required autofocus>    
                                @if ($errors->has('nbre_photos_a_verifier'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photos_a_verifier') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photo_enrole_manuellement') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photo_enrole_manuellement">Nbre de photos enrolées manuellement<span class="text-danger">*</span></label>
                            <input id="nbre_photo_enrole_manuellement" type="number"  class="form-control" name="nbre_photo_enrole_manuellement" min="0" placeholder="Entrer nombre de photos enrolées manuellement" required autofocus>    
                                @if ($errors->has('nbre_photo_enrole_manuellement'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photo_enrole_manuellement') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photo_triees') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photo_triees">Nbre de photos triées<span class="text-danger">*</span></label>
                            <input id="nbre_photo_triees" type="number"  class="form-control" name="nbre_photo_triees" min="0" placeholder="Entrer de photo triées" required autofocus>    
                                @if ($errors->has('nbre_photo_triees'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photo_triees') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photo_investigues') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photo_investigues">Nbre de photos investiguées<span class="text-danger">*</span></label>
                            <input id="nbre_photo_investigues" type="number"  class="form-control" name="nbre_photo_investigues" min="0" placeholder="Entrer nombre de photos investigués" required autofocus>    
                                @if ($errors->has('nbre_photo_investigues'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photo_investigues') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photo_en_attente_de_tirage') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photo_en_attente_de_tirage">Nbre de photos en attente de tirage<span class="text-danger">*</span></label>
                            <input id="nbre_photo_en_attente_de_tirage" type="number"  class="form-control" name="nbre_photo_en_attente_de_tirage" min="0" placeholder="Nombre de photo en attente de tirage" required autofocus>    
                                @if ($errors->has('nbre_photo_en_attente_de_tirage'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photo_en_attente_de_tirage') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photo_en_attente_dinvestigation') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photo_en_attente_dinvestigation">Nbre de photo en attente d'investigation<span class="text-danger">*</span></label>
                            <input id="nbre_photo_en_attente_dinvestigation" type="number"  class="form-control" name="nbre_photo_en_attente_dinvestigation" min="0" placeholder="Entrer nombre de photo en attente d'investigation" required autofocus>    
                                @if ($errors->has('nbre_photo_en_attente_dinvestigation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photo_en_attente_dinvestigation') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photo_cas_fraude') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photo_cas_fraude">Nbre de photo en cas de fraude<span class="text-danger">*</span></label>
                            <input id="nbre_photo_cas_fraude" type="number"  class="form-control" name="nbre_photo_cas_fraude" min="0" placeholder="Entrer nombre de photo cas de fraude" required autofocus>    
                                @if ($errors->has('nbre_photo_cas_fraude'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_photo_cas_fraude') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
           </fieldset>
                
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

    function edit_registre(id){
                var id=id;
                $("#id_registre").val(id);
            var url = "{{ route('registre.getById') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        console.log(data)
                        $("#eff_theorique_u").val(data.effectif_theorique);
                        $("#eff_present_u").val(data.effectif_present);
                        $("#eff_absent_u").val(data.effectif_absent);
                        $("#eff_conge_u").val(data.effectif_conge);
                        $("#eff_mission_u").val(data.effectif_mission);
                        $("#eff_maladie_u").val(data.effectif_malade);
                        $("#eff_permission_u").val(data.effectif_permission);
                        $("#nbre_lot_introduit_u").val(data.nbre_lot_introduit);
                        $("#nbre_demande_saisie_u").val(data.nbre_demande_saisie);
                        $("#nbre_demande_supervise_u").val(data.nbre_demande_supervise);
                        $("#nbre_carte_imprime_u").val(data.nbre_carte_imprime);
                        $("#nrbre_carte_assure_u").val(data.nbre_carte_assure);
                        $("#nbre_carte_endomage_u").val(data.nbre_carte_endomage);
                        $("#date_effet_u").val(data.date_effet);

                        $("#nbre_photos_a_verifier_u").val(data.nbre_photos_a_verifier);
                        $("#nbre_photo_enrole_manuellement_u").val(data.nbre_photo_enrole_manuellement);
                        $("#nbre_photo_triees_u").val(data.nbre_photo_triees);
                        $("#nbre_photo_investigues_u").val(data.nbre_photo_investigues);
                        $("#nbre_photo_en_attente_de_tirage_u").val(data.nbre_photo_en_attente_de_tirage);
                        $("#nbre_photo_en_attente_dinvestigation_u").val(data.nbre_photo_en_attente_dinvestigation);
                        $("#nbre_photo_cas_fraude_u").val(data.nbre_photo_cas_fraude);
                        $("#id_registre").val(data.id);

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

