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
                    <th>Nbre lot recu</th>
                    <th>Demandes</th>
                    <th>Demandes en instance</th>
                    <th>Cartes transmises</th>
                    <th>Stock de teslins</th>
                    <th>Stock de laminés imprimés</th>
                    <th>Stock de laminés vierges</th>
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
                    <td>{{$registre->nbre_demande_en_instance}}</td>
                    <td>{{$registre->nbre_carte_transmise}}</td>
                    <td>{{$registre->stock_de_teslin}}</td>
                    <td>{{$registre->stock_de_teslin}}</td>
                    <td>{{$registre->stock_de_tamine_imprime}}</td>
                    <td>{{$registre->stock_de_tamine_vierge}}</td>
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
                <th>Nbre lot recu</th>
                <th>Demandes</th>
                <th>Demandes en instance</th>
                <th>Cartes transmises</th>
                <th>Stock de teslins</th>
                <th>Stock de laminés imprimés</th>
                <th>Stock de laminés vierges</th>
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
          <h4 class="modal-title">Modifier la ligne du registre</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('registre.modifier') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="id_registre" name="registre_id">
                
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
                                <select id="example-chosen-multiple" name="absents[]" class="select-chosen" data-placeholder="Selectionner les absents" style="width: 250px;" multiple>
                                   @foreach ($users as $user )
                                         <option value="{{ $user->id }}"> {{ $user->matricule  }} - {{ $user->name  }} {{ $user->prenom  }} </option>
                                   @endforeach
                                </select>
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
                        <div class="form-group{{ $errors->has('nbre_lot_introduit') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_lot_introduit">Nbre de lot introduits<span class="text-danger">*</span></label>
                            <input id="nbre_lot_introduit_u" type="number"  class="form-control" name="nbre_lot_introduit" min="0" placeholder="Entrer nombre de carte recu" required autofocus>    
                                @if ($errors->has('nbre_lot_introduit'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_lot_introduit') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_demande_saisie') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_demande_saisie">Nbre de demandes saisie<span class="text-danger">*</span></label>
                            <input id="nbre_demande_saisie_u" type="number"  class="form-control" name="nbre_demande_saisie" min="0" placeholder="Entrer nombre de carte recu" required autofocus>    
                                @if ($errors->has('nbre_demande_saisie'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_demande_saisie') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photos_a_verifier') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photos_a_verifier">Nbre de demandes en instance<span class="text-danger">*</span></label>
                            <input id="nbre_demande_en_instance_u" type="number"  class="form-control" name="nbre_demande_en_instance" min="0" placeholder="Entrer nombre de carte recu" required autofocus>    
                                @if ($errors->has('nbre_demande_en_instance'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_demande_en_instance') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_carte_transmise') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_carte_transmise">Nbre de cartes transmises<em></em><span class="text-danger">*</span></label>
                            <input id="nbre_carte_transmise_u" type="number"  class="form-control" name="nbre_carte_transmise" min="0" placeholder="Entrer le nombre de carte transmises" required autofocus>    
                                @if ($errors->has('nbre_carte_transmise'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_carte_transmise') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('stock_de_teslin') ? ' has-error' : '' }}">
                            <label class=" control-label" for="stock_de_teslin">Stock de teslin<span class="text-danger">*</span></label>
                            <input id="stock_de_teslin_u" type="number"  class="form-control" name="stock_de_teslin" min="0" placeholder="Entrer de photo triées" required autofocus>    
                                @if ($errors->has('stock_de_teslin'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('stock_de_teslin') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('stock_de_tamine_imprime') ? ' has-error' : '' }}">
                            <label class=" control-label" for="stock_de_tamine_imprime">Stock de tamine imprimé<span class="text-danger">*</span></label>
                            <input id="stock_de_tamine_imprime_u" type="number"  class="form-control" name="stock_de_tamine_imprime" min="0" placeholder="Entrer de photo triées" required autofocus>    
                                @if ($errors->has('stock_de_tamine_imprime'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('stock_de_tamine_imprime') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('stock_de_tamine_vierge') ? ' has-error' : '' }}">
                            <label class=" control-label" for="stock_de_tamine_vierge">Stock de tamine vierge<span class="text-danger">*</span></label>
                            <input id="stock_de_tamine_vierge_u" type="number"  class="form-control" name="stock_de_tamine_vierge" min="0" placeholder="Entrer de photo triées" required autofocus>    
                                @if ($errors->has('stock_de_tamine_vierge'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('stock_de_tamine_vierge') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-sm-4">
                        <!-- textarea -->
                        <div class="form-group">
                          <label>Observations</label>
                          <textarea class="form-control" id="observation_u" name="observation" rows="3" placeholder="Entrer une description du centre de collecte ..." required></textarea>
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
          <h4 class="modal-title">Ajouter une nouvelle ligne au registre</h4>
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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('nbre_lot_introduit') ? ' has-error' : '' }}">
                                <label class=" control-label" for="nbre_lot_introduit">Nbre de lot introduits<span class="text-danger">*</span></label>
                                <input id="nbre_lot_introduit" type="number"  class="form-control" name="nbre_lot_introduit" min="0" placeholder="Entrer nombre de carte recu" required autofocus>    
                                    @if ($errors->has('nbre_lot_introduit'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nbre_lot_introduit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('nbre_demande_saisie') ? ' has-error' : '' }}">
                                <label class=" control-label" for="nbre_demande_saisie">Nbre de demandes saisie<span class="text-danger">*</span></label>
                                <input id="nbre_demande_saisie" type="number"  class="form-control" name="nbre_demande_saisie" min="0" placeholder="Entrer nombre de carte recu" required autofocus>    
                                    @if ($errors->has('nbre_demande_saisie'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nbre_demande_saisie') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_photos_a_verifier') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_photos_a_verifier">Nbre de demandes en instance<span class="text-danger">*</span></label>
                            <input id="nbre_demande_en_instance" type="number"  class="form-control" name="nbre_demande_en_instance" min="0" placeholder="Entrer nombre de carte recu" required autofocus>    
                                @if ($errors->has('nbre_demande_en_instance'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_demande_en_instance') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('nbre_carte_transmise') ? ' has-error' : '' }}">
                            <label class=" control-label" for="nbre_carte_transmise">Nbre de cartes transmises<em></em><span class="text-danger">*</span></label>
                            <input id="nbre_carte_transmise" type="number"  class="form-control" name="nbre_carte_transmise" min="0" placeholder="Entrer le nombre de carte transmises" required autofocus>    
                                @if ($errors->has('nbre_carte_transmise'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nbre_carte_transmise') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('stock_de_teslin') ? ' has-error' : '' }}">
                            <label class=" control-label" for="stock_de_teslin">Stock de teslin<span class="text-danger">*</span></label>
                            <input id="stock_de_teslin" type="number"  class="form-control" name="stock_de_teslin" min="0" placeholder="Entrer de photo triées" required autofocus>    
                                @if ($errors->has('stock_de_teslin'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('stock_de_teslin') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('stock_de_tamine_imprime') ? ' has-error' : '' }}">
                            <label class=" control-label" for="stock_de_tamine_imprime">Stock de tamine imprimé<span class="text-danger">*</span></label>
                            <input id="stock_de_tamine_imprime" type="number"  class="form-control" name="stock_de_tamine_imprime" min="0" placeholder="Entrer de photo triées" required autofocus>    
                                @if ($errors->has('stock_de_tamine_imprime'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('stock_de_tamine_imprime') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('stock_de_tamine_vierge') ? ' has-error' : '' }}">
                            <label class=" control-label" for="stock_de_tamine_vierge">Stock de tamine vierge<span class="text-danger">*</span></label>
                            <input id="stock_de_tamine_vierge" type="number"  class="form-control" name="stock_de_tamine_vierge" min="0" placeholder="Entrer de photo triées" required autofocus>    
                                @if ($errors->has('stock_de_tamine_vierge'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('stock_de_tamine_vierge') }}</strong>
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

                        $("#nbre_demande_en_instance_u").val(data.nbre_demande_en_instance);
                        $("#nbre_carte_transmise_u").val(data.nbre_carte_transmise);
                        $("#stock_de_tamine_imprime_u").val(data.stock_de_tamine_imprime);
                        $("#stock_de_teslin_u").val(data.stock_de_teslin);
                        $("#stock_de_tamine_vierge_u").val(data.stock_de_tamine_vierge);
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

