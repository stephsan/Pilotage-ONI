@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('administration-centreCollecte', 'active')
@section('content')

@section('content')
<div class="card card-success col-md-12 col-md-offset-2">
    <button  data-toggle="modal" class="btn btn-success col-md-2 pull-right mt-2" style="margin-bottom: 7px;" data-target="#create-centre"><span></span> Ajouter un CCD</button>

    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Liste des centres de collecte</h3>
    </div>

<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>Code</th>
                    <th>Libelle</th>
                    <th>Antenne</th>
                    <th>Province</th>
                    <th>Commune</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @foreach($centres as $centre)
                <tr>
                    <td>{{$centre->code}}</td>
                    <td>{{$centre->libelle}}</td>
                    <td>{{$centre->ctid->antenne->nom_de_lantenne}}</td>
                    <td>{{getlibelle($centre->province_id)}}</td>
                    <td>{{$centre->commune->libelle}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                             {{-- @can('role.update', Auth::user()) --}}
                                <button  data-toggle="modal" onclick="edit_centre({{ $centre->id }});"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" data-target="#update-centre" ><i class="fa fa-edit"></i></a>
                            {{-- @endcan --}}
                            @can('role.delete',Auth::user())
                                <a href="#modal-confirm-delete" onclick="delConfirm({{ $role->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                            @endcan
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Code</th>
                <th>Libelle</th>
                <th>Antenne</th>
                <th>Province</th>
                <th>Commune</th>
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
          <h4 class="modal-title">Modifier un centre de collecte</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('centreCollecte.modifier') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="id_centre" name="centre_id">
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}} 
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="antenne">selectionner l'antenne<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="antenne_u" name="antenne" data-placeholder="Chosir l'antennes .." value="{{old("antenne")}}" onchange="getCitds('antenne_u', 'ctid_u');"required>
                                    <option></option>
                                        @foreach ($antennes as $antenne )
                                                <option value="{{ $antenne->id}}" {{ old('antenne') == $antenne->id ? 'selected' : '' }}>{{ $antenne->nom_de_lantenne }}</option>
                                        @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="region">Ctid concerné<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="ctid_u" name="ctid" data-placeholder="Chosir Region Collecte .." onchange="getCommuneOuCcdByCtid('ctid_u','commune_u','commune')" required>
                                    <option></option>
                                    @foreach ($ctids as $ctid )
                                            <option value="{{ $ctid->id  }}" {{ old('ctid') == $ctid->id ? 'selected' : '' }}>{{ $ctid->libelle }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="example-chosen">Commune/Ville du centre<span class="text-danger">*</span></label>
                                <select id="commune_u" name="commune" class="form-control select2" data-placeholder="Chosir la commune du centre ..." onchange="changeValue('commune_u', 'arrondissement_u', {{ env('PARAMETRE_ID_ARRONDISSEMENT') }});" style="width: 100%;" required>
                                    @foreach ($communes as $commune )
                                    <option value="{{ $commune->id  }}" {{ old('region') == $commune->id ? 'selected' : '' }}>{{ $commune->libelle }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nom du centre de collecte<span class="text-danger">*</span></label>
                    <input id="libelle_u" type="text"  class="form-control" name="libelle" max="40" placeholder="Entrer le nom du centre de collecte" required autofocus>    
                        @if ($errors->has('libelle'))
                        <span class="help-block">
                            <strong>{{ $errors->first('libelle') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Décrire le centre de collecte</label>
                <textarea class="form-control" name="description" id="description_u"  rows="3" placeholder="Entrer une description du centre de collecte ..." required></textarea>
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
          <h4 class="modal-title">Ajouter un centre de collecte</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('centreCollecte.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="region">Choisir l'antenne<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="antenne" name="antenne" data-placeholder="Chosir Region Collecte .." value="{{old("region")}}" onchange="getCitds('antenne', 'ctid');" required>
                                    <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                    @foreach ($antennes as $antenne )
                                            <option value="{{ $antenne->id  }}" {{ old('antenne') == $antenne->id ? 'selected' : '' }}>{{ $antenne->nom_de_lantenne }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Choisir le CTID concerné<span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" id="ctid" name="ctid" data-placeholder="Selectionner le CTID concerné.." value="{{old("ctid")}}" onchange="getCommuneOuCcdByCtid('ctid','commune','commune')"  required>
                                <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                {{-- @foreach ($ctids as $ctid )
                                        <option value="{{ $ctid->id  }}" {{ old('ctid') == $ctid->id ? 'selected' : '' }}>{{ $ctid->libelle }}</option>
                                @endforeach --}}
                            </select>
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="example-chosen">Commune/Ville du centre<span class="text-danger">*</span></label>
                                <select id="commune" name="commune" class="form-control select2" data-placeholder="Chosir la commune de centre ..." onchange="changeValue('commune', 'arrondissement', {{ env('PARAMETRE_ID_ARRONDISSEMENT') }});" style="width: 100%;" required>
                                    <option  value="{{ old('commune') }}" {{ old('commune') == old('commune') ? 'selected' : '' }}>{{ getlibelle(old('commune')) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                </select>
                        </div>
                    </div>
                    
                </div>
        <div class="row">
                
            {{-- <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="province_residence">Province du centre<span class="text-danger">*</span></label>
                        <select id="province" name="province" class="form-control select2" onchange="changeValue('province', 'commune', {{ env('PARAMETRE_ID_COMMUNE') }});" data-placeholder="Chosir la province du centre de collecte .."  style="width: 100%;" required>
                            <option  value="{{ old('province') }}" {{ old('province') == old('province') ? 'selected' : '' }}>{{ getlibelle(old('province')) }}</option>
                        </select>
                </div>
            </div> --}}
            {{-- <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="example-chosen">Commune/Ville du centre<span class="text-danger">*</span></label>
                        <select id="commune" name="commune" class="form-control select2" data-placeholder="Chosir la commune de l'AOP ..." onchange="changeValue('commune', 'arrondissement', {{ env('PARAMETRE_ID_ARRONDISSEMENT') }});" style="width: 100%;" required>
                            <option  value="{{ old('commune') }}" {{ old('commune') == old('commune') ? 'selected' : '' }}>{{ getlibelle(old('commune')) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                        </select>
                </div>
            </div> --}}
        </div>  
        <div class="row">
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nom du centre de collecte<span class="text-danger">*</span></label>
                    <input id="name" type="text"  class="form-control" name="libelle" max="40" placeholder="Entrer le nom du centre de collecte" required autofocus>    
                        @if ($errors->has('libelle'))
                        <span class="help-block">
                            <strong>{{ $errors->first('libelle') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Decrire le centre de collecte</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Entrer une description du centre de collecte ..." required></textarea>
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

    function edit_centre(id){
                var id=id;
                $("#province_u").val('');
                $("#commune_u").val('');
                $("#libelle_u").val('');
                $("#code_u").val('');
                $("#id_centre").val(id);
                $("#description_u").val('');
            var url = "{{ route('centreCollecte.getById') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        console.log(data)
                        $("#antenne_u").val(data.antenne).change();
                        $("#ctid_u").val(data.ctid).change();
                        $("#commune_u").val(data.commune);
                        $("#libelle_u").val(data.libelle);
                        $("#description_u").val(data.description);
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

