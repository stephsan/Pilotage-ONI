@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('administration-role', 'active')
   
    @section('content')
    <div class="container">
        <div class="row">
            <div class="card card-success col-md-12 col-md-offset-2">
                <div class="card-header">
                  <h3 class="card-title">Modifier le CTID</h3>
                </div>
                <div class="card-body">
                    <fo<form id="form-validation" method="POST"  action="{{ route('centreTraitement.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="region">Region du CTID :<span class="text-danger">*</span></label>
                                        <select class="form-control select2" style="width: 100%;" id="region" name="region" data-placeholder="Chosir Region Collecte .." value="{{old("region")}}" onchange="changeValue('region', 'province', {{ env('PARAMETRE_ID_PROVINCE') }});" required>
                                            <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                            @foreach ($regions as $region )
                                                    <option value="{{ $region->id }}" 
                                                        @if ($centre->region_id==$region->id)
                                                           selected
                                                        @endif >{{ $region->libelle }}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                    <label class=" control-label" for="libelle">Nom du CTID {{ $centre->libelle }} <span class="text-danger">*</span></label>
                                    <input id="name" type="text"  class="form-control" name="libelle" value="{{ $centre->libelle }}"  required autofocus>    
                                        @if ($errors->has('libelle'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('libelle') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                            </div>
                        </div>
                <div class="row">
                    <div class="col-sm-8">
                      <div class="form-group">
                        <label>Décrire le CTID</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Entrer une description du centre de collecte ..." required></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="control-label" for="region"> Selectionner les CCD couverts<span class="text-danger">*</span></label>
                                <select class="form-control select2" multiple="multiple" style="width: 100%;" id="CCD" name="ccds[]" data-placeholder="Chosir Region Collecte .." value="{{old("region")}}" onchange="changeValue('region', 'province', {{ env('PARAMETRE_ID_PROVINCE') }});" required>
                                    <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                    @foreach ($ccds as $ccd )
                                            <option value="{{ $ccd->id  }}" {{ old('region') == $ccd->id ? 'selected' : '' }}>{{ $ccd->libelle }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div> 
                <fieldset>
                    <legend><i class="fa fa-angle-right"></i> CCD affectés</legend>
                    <div class="form-group">
                        @foreach ($ccds as $ccd)
                            <div class="col-lg-3">
                               <label><input type="checkbox"name='ccds[]' value="{{ $ccd->id }}"
                                        @foreach ($centre->ccds as $centre_ccd )
                                            {{ $centre_ccd  }}
                                            @if ($centre_ccd->id == $ccd->id)
                                                checked
                                            @endif
                                        @endforeach
                                > {{ $ccd->libelle }}</label>
                            </div>
                        @endforeach
                    </div>
            </fieldset>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"></i> Enregistrer</button>
                </div> 
                </form>
                </div>
                <!-- /.card-body -->
              </div>
           
        </div>
    </div>
@endsection
