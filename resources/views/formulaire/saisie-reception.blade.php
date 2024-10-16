@extends('backend.partials.main')
@section('formulaire', 'menu-open')
@section('reception-lot', 'active')
@section('content')

@section('content')
<div class="card card-success col-md-12 col-md-offset-2">
    <button  data-toggle="modal" class="btn btn-success col-md-2" data-target="#create-formulaire" style="margin-bottom: 7px;"><span> Nouveau lot</span></button>

    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Registre des formulaires recus pour la production  </h3>
    </div>

<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr style="background-color:#0b9e44; color:white">
                    <th>Numero</th>
                    <th>Antenne</th>
                    <th>CTID</th>
                    <th>CCD</th>
                    <th>Num lot</th>
                    <th>Date</th>
                    <th>Actions</th>
                    <th>1er Serie</th>
                    <th>Dernier Serie</th>
                    <th>Nombre formulaire</th>
                </tr>
        </thead>
        <tbody>
                    @php
                    $i=0;
                @endphp
            @foreach($formulaires as $formulaire)
                    @php
                    $i++;
                @endphp
                <tr>
                   
                    <td>{{$i}}</td>
                    <td>{{$formulaire->ctid->antenne->nom_de_lantenne}}</td>
                    <td>{{$formulaire->ctid->libelle}}</td>
                    <td>{{$formulaire->ccd->libelle}}</td>
                    <td>{{$formulaire->numero_lot}}</td>
                    <td>{{format_date($formulaire->created_at)}}</td>
                    <td class="text-center">
                        <div class="btn-group">
                    @can('formulaire.update_reception',Auth::user())
                        @if(!$formulaire->quittance)
                            <button  data-toggle="modal" onclick="edit_formulaire({{ $formulaire->id }});"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" data-target="#update-formulaire" ><i class="fa fa-edit"></i></a>
                        @endif
                        
                    @endcan
                    @can('create_quittance_recette',Auth::user())
                        @if(return_nbre_quittance_recette($formulaire->id) == 0)
                            <button data-toggle="modal" onclick="edit_formulaire({{ $formulaire->id }});"  data-toggle="tooltip" title="Convertir en quittance recette" class="btn btn-xs btn-default" data-target="#create-recette" ><i class="fa fa-edit"></i></a>
                        @endif
                        @if(return_nbre_quittance_recette($formulaire->id) != 0 && $formulaire->nbre_carte_sortie==null )
                            <button data-toggle="modal" onclick="edit_formulaire({{ $formulaire->id }});"  data-toggle="tooltip" title="Enregistrer la sortie du lot" class="btn btn-xs btn-default" data-target="#sortie-de-lot" ><i class="fa fa-edit"></i></a>
                        @endif
                    @endcan
                        @can('role.delete',Auth::user())
                            <a href="#modal-confirm-delete" onclick="delConfirm({{ $formulaire->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                        @endcan
                        </div>
                    </td>
                    <td>{{$formulaire->premier_serie}}</td>
                    <td>{{$formulaire->dernier_serie}}</td>
                    <td>{{$formulaire->nbre_formulaire}}</td>

                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Numero</th>
                    <th>Antenne</th>
                    <th>CTID</th>
                    <th>CCD</th>
                    <th>Num lot</th>
                    <th>Date</th>
                    <th>Actions</th>
                    <th>1er Serie</th>
                    <th>Dernier Serie</th>
                    <th>Nombre formulaire</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
@section('modalSection')

<div class="modal fade" id="sortie-de-lot">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Enregistrer la sortie du lot</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('formulaire.sortie') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="formulaire_sortie" name="formulaire_prod">
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}} 
                <input id="ccd_q" type="hidden" class="form-control" name="premier_serie"  placeholder="1er numero de la serie" required autofocus>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class="control-label" for="libelle">Numero de lot<span class="text-danger">*</span></label>
                            <input id="numero_lot_s" type="text" class="form-control" name="premier_serie"  placeholder="1er numero de la serie" required autofocus disabled>    
                            </div>
                    </div>
                    <div class="col-md-6" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">CCD concerné<span class="text-danger">*</span></label>
                            <input id="ccd_libelle_sortie" type="text" class="form-control" name="ccd_concernee"  placeholder="1er numero de la serie" required autofocus disabled>    
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-6" >
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class=" control-label" for="libelle">Nombre de formulaire<span class="text-danger">*</span></label>
                                <input id="nbre_formulaire_sortie" type="number" class="form-control" name="nombre_formulaire_sortie" disabled required autofocus>    
                                    @if ($errors->has('nombre_formulaire'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre_formulaire') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('nombre_carte_sortie') ? ' has-error' : '' }}">
                                <label class=" control-label" for="libelle">Nombre de carte sortie<span class="text-danger">*</span></label>
                                <input id="nombre_carte_sortie" type="text" class="form-control" name="nombre_carte_sortie"  placeholder="Entrer le nombre de carte sortie" required autofocus>    
                                    @if ($errors->has('nombre_carte_sortie'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre_carte_sortie') }}</strong>
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
<div class="modal fade" id="create-recette">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Enregistrer une quittance recette</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p id="message_rejet" style="background-color: #d56d72; display:none; text-align:center">Le nombre de rejet ne peut pas depasser le nombre de formulaire</p>
            <form id="form-validation" method="POST"  action="{{ route('recette_quittance.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="formulaire_prod" name="formulaire_prod">
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}} 
                <input id="ccd_q" type="hidden" class="form-control" name="premier_serie"  placeholder="1er numero de la serie" required autofocus>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Numero de lot<span class="text-danger">*</span></label>
                            <input id="numero_lot_q" type="text" class="form-control" name="premier_serie"  placeholder="1er numero de la serie" required autofocus disabled>    
                            </div>
                    </div>
                    <div class="col-md-6" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Montant<span class="text-danger">*</span></label>
                            <input id="montant_q" type="text"  class="form-control" name="montant"  required autofocus  readonly="true">    
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
                            <input id="ccd_libelle" type="text" class="form-control" name="ccd_concernee"  placeholder="1er numero de la serie" required autofocus disabled>    
                            </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Date Siege<span class="text-danger">*</span></label>
                            <input id="date_siege_q" type="text"  class="form-control date_affecte" name="date_siege"  required autofocus>    
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
                        <input id="numero_oni_q" type="text" class="form-control" name="numero_oni"  placeholder="Entrer le numero ONI" required autofocus>    
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
                    <input id="premier_serie_q" type="text" class="form-control" name="premier_serie"  placeholder="1er numero de la serie" disabled required autofocus>    
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
                    <input id="dernier_serie_q" type="text" class="form-control" name="dernier_serie"  placeholder="dernier numero de la serie" disabled required autofocus>    
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
                    <input id="numero_tresor_q" type="text" class="form-control" name="numero_tresor"  placeholder="Entrer le numero ONI" required autofocus>    
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
                    <input id="valeur_form_q" type="text" class="form-control" name="valeur_form" value="2500" readonly="true" required  autofocus>    
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
                    <input id="nbre_formulaire_q" type="number"  class="form-control" name="nombre_formulaire" disabled onchange="verifierSaisiequittance('ccd_u','nombre_formulaire_u','modification');" required autofocus>    
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
                    <input id="nbre_rejet_q"  type="number"  class="form-control" name="nombre_rejet" onchange="setMontantRecette()"  required autofocus>    
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
            <button type="submit" class="btn btn-success" id="button_quittance"><i class="fa fa-arrow-right"></i> Enregistrer</button>
        </div> 
        </form>
        </div>
      
      </div>
    </div>
</div>


<div class="modal fade" id="update-formulaire">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modifier le lot</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('formulaire_recu.modifier') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="formulaire_recu" name="formulaire_recu">
                
                <div class="row">
                    <div class="col-md-8" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Numéro lot<span class="text-danger">*</span></label>
                            <input id="numero_lot_u" type="text"  class="form-control" name="numero_lot"  required autofocus>    
                                @if ($errors->has('numero_lot'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('numero_lot') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="region">Selectionner le Ctid <span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="ctid_u" name="ctid" data-placeholder="Selectionner le CITD .." onchange="getCommuneOuCcdByCtid('ctid_u','ccd_u','ccd')" required>
                                    <option></option>
                                    @foreach ($ctids as $ctid )
                                            <option value="{{ $ctid->id  }}" {{ old('ctid') == $ctid->id ? 'selected' : '' }}>{{ $ctid->libelle }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Choisir le CCD concerné<span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" id="ccd_u" name="ccd" data-placeholder="Chosir Region Collecte .." value="{{old("ctid")}}"  required>
                                <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                {{-- @foreach ($ccds as $ccd )
                                        <option value="{{ $ccd->id  }}" {{ old('ccd') == $ccd->id ? 'selected' : '' }}>{{ $ccd->libelle }}</option>
                                @endforeach --}}
                            </select>
                            </div>
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
            <div class="col-md-4" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nombre de formulaire<span class="text-danger">*</span></label>
                    <input id="nbre_formulaire_u" type="number"  class="form-control" name="nombre_formulaire" onchange="verifierSaisiequittance('ccd_u','nbre_formulaire_u','modification','formulaire_recu');"  required autofocus>    
                        @if ($errors->has('nombre_formulaire'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre_formulaire') }}</strong>
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
<div class="modal fade" id="create-formulaire">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"> Nouveau lot de formulaire a produire</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('formulaire_recu.save') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}               
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}}
                <div class="row">
                    <p style="background-color: #d56d72; display:none; text-align:center" class="message_verification_saisie_nombre col-md-8 col-md-offset-3"> Attention vous ne pouvez pas saisir ce nombre de formulaire pour ce CTID !!! Consulter le recap des formulaires</p>
                </div>
                <div class="row">
                    <div class="col-md-8" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Entrer le numéro de lot<span class="text-danger">*</span></label>
                            <input id="numero_lot" type="text"  class="form-control" name="numero_lot"  data-placeholder="Entrer le numéro de lot .."   required autofocus>    
                                @if ($errors->has('numero_lot'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('numero_lot') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="region">Selectionner le Ctid <span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="ctid" name="ctid" data-placeholder="Selectionner le CITD .." onchange="getCommuneOuCcdByCtid('ctid','ccd','ccd')" required>
                                    <option></option>
                                    <option></option>
                                    @foreach ($ctids as $ctid )
                                            <option value="{{ $ctid->id  }}" {{ old('ctid') == $ctid->id ? 'selected' : '' }}>{{ $ctid->libelle }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Selectionner le CCD<span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" id="ccd" name="ccd" data-placeholder="Chosir Region Collecte .." value="{{old("ctid")}}"  required>
                                <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                {{-- @foreach ($ccds as $ccd )
                                        <option value="{{ $ccd->id  }}" {{ old('ccd') == $ccd->id ? 'selected' : '' }}>{{ $ccd->libelle }}</option>
                                @endforeach --}}
                            </select>
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
            <div class="col-md-4" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nombre de formulaire<span class="text-danger">*</span></label>
                    <input id="nbre_formulaire" type="number"  class="form-control" name="nombre_formulaire"  onchange="verifierSaisiequittance('ccd','nbre_formulaire','creation');" required autofocus>    
                        @if ($errors->has('nombre_formulaire'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre_formulaire') }}</strong>
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
function verifierSaisiequittance(type_operation){
           var nbre_formulaire= $('#nombre_formulaire').val()
           var ccd= $('#ccd').val()
          // $('#numero_oni_q').val(' ');
            var url = "{{ route('quittance.verifier_saisie') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {nbre_formulaire: nbre_formulaire, ccd: ccd, type_operation: type_operation} ,
                    error:function(){alert('error');},
                    success:function(data){
                        if(data < 0){
                            $('#nombre_formulaire').val('')
                            $('.message_verification_saisie_nombre').show()
                        }
                        else{
                            $('.message_verification_saisie_nombre').hide()
                        }
                        
                    }
                });
}
function setMontantRecette(){
        var valeur_formulaire= $('#valeur_form_q').val()
        var nbre_formulaire= $('#nbre_formulaire_q').val()
        var nbre_rejet= $('#nbre_rejet_q').val()
        if( parseInt(nbre_rejet) > parseInt(nbre_formulaire) ){
            $('#message_rejet').show();
            $('#button_quittance').prop("disabled", true);
        }
        else{
            $('#message_rejet').hide();
            $('#button_quittance').prop("disabled", false);
        }
        var montant= (parseInt(nbre_formulaire) - parseInt(nbre_rejet))*2500;
        $('#montant_q').val(montant);
    }
    function edit_formulaire(id){
                var id=id;
                $("#formulaire_recu").val(id);
                $('#numero_oni_q').val('');
                $('#date_siege_q').val('');
                $('#ccd_libelle').val('');
                $('#ccd_libelle_sortie').val('');
                $('#nbre_formulaire_q').val('');
                $('#nbre_formulaire_sortie').val('');
                $('#formulaire_prod').val('');
                $('#numero_lot_s').val('');
                $('#nbre_rejet_q').val('');
                $('#montant_q').val('');
            var url = "{{ route('formulaire_recu.getById') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        console.log(data)
                        $("#ctid_u").val(data.centre_traitement_id).change();
                        $("#ccd_u").val(data.centre_collecte_id)
                        $("#premier_serie_u").val(data.premier_serie);
                        $("#dernier_serie_u").val(data.dernier_serie);
                        $("#numero_lot_u").val(data.numero_lot);
                        $("#nbre_formulaire_u").val(data.nombre);
                        $("#nbre_rejet_u").val(data.nbre_rejet);
                        $("#date_u").val(data.date);
                        $("#ccd_q").val(data.centre_collecte_id);
                        $("#premier_serie_q").val(data.premier_serie);
                        $("#dernier_serie_q").val(data.dernier_serie);
                        $("#nbre_formulaire_q").val(data.nombre);
                        $("#nbre_formulaire_sortie").val(data.nombre);
                        $("#formulaire_prod").val(id);
                        $("#formulaire_sortie").val(id);
                        $("#numero_lot_q").val(data.numero_lot);
                        $("#numero_lot_s").val(data.numero_lot);
                        $("#ccd_libelle").val(data.centre_collecte_libelle);
                        $("#ccd_libelle_sortie").val(data.centre_collecte_libelle);
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

