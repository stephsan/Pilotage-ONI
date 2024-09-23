@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('administration-centreTraitement', 'active')
@section('content')

@section('content')

<div class="card card-success col-md-12 col-md-offset-2">
    <button  data-toggle="modal" class="btn btn-success col-md-2" style="margin-bottom: 7px;" data-target="#create-centre"><span></span> Ajouter un CTID</button>
    <button  data-toggle="modal" class="btn btn-success col-md-2" style="margin-bottom: 7px;" data-target="#create-centre"><span></span> Importer</button>
    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title" >Liste des CTID</h3>
    </div>

<table id="example1" class="table table-bordered table-striped" >
        <thead>
                <tr style="background-color:#0b9e44; color:white">
                    <th>Code</th>
                    <th>Antenne</th>
                    <th>Libelle</th>
                    <th>Region</th>
                    <th>Province</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @foreach($centres as $centre)
                <tr>
                    <td>{{$centre->code}}</td>
                    <td>{{$centre->antenne->nom_de_lantenne}}</td>
                    <td>{{$centre->libelle}}</td>
                    <td>{{$centre->region->libelle}}</td>
                    <td>{{getlibelle($centre->province_id)}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                             {{-- @can('role.update', Auth::user()) --}}
                             <button  data-toggle="modal" onclick="edit_centre({{ $centre->id }});"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" data-target="#update-centre" ><i class="fa fa-edit"></i></a>
                                {{-- <a  href="{{ route('centreTraitement.edit',$centre) }}"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" data-target="#update-centre" ><i class="fa fa-edit"></i></a> --}}
                            {{-- @endcan --}}
                            @can('role.delete',Auth::user())
                                <a href="#modal-confirm-delete"  data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                            @endcan
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Code</th>
                <th>Antenne</th>
                <th>Libelle</th>
                <th>Region</th>
                <th>Province</th>
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
          <h4 class="modal-title">Modifier un centre de traitement</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('centreTraitement.modifier') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
               <input type="hidden" id='centre_id' name="centre_id" > 
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="region">Antenne<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="antenne_u" name="antenne" data-placeholder="Chosir l'antenne .." value="{{old("antenne")}}" required>
                                    <option></option>
                                    @foreach ($antennes as $antenne )
                                            <option value="{{ $antenne->id  }}" {{ old('antenne') == $antenne->id ? 'selected' : '' }}>{{ $antenne->nom_de_lantenne }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="region">Region Concernée<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="region_u" name="region" data-placeholder="Chosir Region Collecte .." value="{{old("region")}}" onchange="changeValue('region_u', 'province_u', {{ env('PARAMETRE_ID_PROVINCE') }});" required>
                                    <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                    @foreach ($regions as $region )
                                            <option value="{{ $region->id  }}" {{ old('region') == $region->id ? 'selected' : '' }}>{{ $region->libelle }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="province_residence">Province du centre<span class="text-danger">*</span></label>
                                <select id="province_u" name="province" class="form-control select2"  data-placeholder="Chosir la province du centre de collecte .."  style="width: 100%;" required>
                                    <option  value="{{ old('province') }}" {{ old('province') == old('province') ? 'selected' : '' }}>{{ getlibelle(old('province')) }}</option>
                                </select>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Seuil maximum<span class="text-danger">*</span></label>
                            <input id="seuil_max_u" type="number" min='0'  class="form-control" name="seuil_max"  placeholder="Entrer le seuil maximal du nombre de formulaire restant" required autofocus>    
                                @if ($errors->has('seuil_max'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('seuil_max') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Seuil minimum<span class="text-danger">*</span></label>
                            <input id="seuil_min_u" type="number" min="0" class="form-control" name="seuil_min"  placeholder="Entrer le seuil minimun du nombre de formulaire restant" required autofocus>    
                                @if ($errors->has('seuil_min'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('seuil_min') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                  </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nom du CTID<span class="text-danger">*</span></label>
                    <input id="libelle_u" type="text"  class="form-control" name="libelle" max="40" placeholder="Entrer le nom du CTID" required autofocus>    
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
                <label>Décrire le CTID</label>
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
    </div>
  </div>
  <div class="modal fade" id="create-centre">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ajouter un CTID</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('centreTraitement.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="region">Antenne :<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="antenne" name="antenne" data-placeholder="Chosir l'antenne .." value="{{old("antenne")}}" required>
                                    <option></option>
                                    @foreach ($antennes as $antenne )
                                            <option value="{{ $antenne->id  }}" {{ old('antenne') == $antenne->id ? 'selected' : '' }}>{{ $antenne->nom_de_lantenne }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="region">Region du CTID :<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="region" name="region" data-placeholder="Chosir Region Collecte .." value="{{old("region")}}" onchange="changeValue('region', 'province', {{ env('PARAMETRE_ID_PROVINCE') }});" required>
                                    <option></option>
                                    @foreach ($regions as $region )
                                            <option value="{{ $region->id  }}" {{ old('region') == $region->id ? 'selected' : '' }}>{{ $region->libelle }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="province_residence">Province du centre<span class="text-danger">*</span></label>
                                <select id="province" name="province" class="form-control select2" onchange="changeValue('province', 'commune', {{ env('PARAMETRE_ID_COMMUNE') }});" data-placeholder="Chosir la province du centre de collecte .."  style="width: 100%;" required>
                                    <option  value="{{ old('province') }}" {{ old('province') == old('province') ? 'selected' : '' }}>{{ getlibelle(old('province')) }}</option>
                                </select>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Seuil maximum<span class="text-danger">*</span></label>
                            <input id="seuil_max" type="number" min="0" class="form-control" name="seuil_max"  placeholder="Entrer le seuil maximal du nombre de formulaire restant" required autofocus>    
                                @if ($errors->has('seuil_max'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('seuil_max') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Seuil minimum<span class="text-danger">*</span></label>
                            <input id="seuil_min" type="number" min="0"  class="form-control" name="seuil_min"  placeholder="Entrer le seuil minimun du nombre de formulaire restant" required autofocus>    
                                @if ($errors->has('seuil_min'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('seuil_min') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                  </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Nom du CTID<span class="text-danger">*</span></label>
                    <input id="name" type="text"  class="form-control" name="libelle" max="40" placeholder="Entrer le nom du centre de collecte" required autofocus>    
                        @if ($errors->has('libelle'))
                        <span class="help-block">
                            <strong>{{ $errors->first('libelle') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Décrire le CTID</label>
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
                //alert(id)
                $("#centre_id").val(id);
                $("#region_u").val('');
                $("#libelle_u").val('');
                $("#code_u").val('');
                $("#description_u").val('');
            var url = "{{ route('centreTraitement.getById') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        console.log(data)
                        $("#region_u").val(data.region_id).change();
                        $("#antenne_u").val(data.antenne_id).change();
                        $("#libelle_u").val(data.libelle);
                        $("#code_u").val(data.code);
                        $("#description_u").val(data.description);
                        $("#seuil_min_u").val(data.seuil_min);
                        $("#seuil_max_u").val(data.seuil_max);
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

