@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('administration-antenne', 'active')
@section('content')

@section('content')
<div class="card card-success col-md-12 col-md-offset-2">
    <button  data-toggle="modal" class="btn btn-success col-md-2 pull-right mt-2" style="margin-bottom: 7px;" data-target="#create-antenne"><span></span> Ajouter une antenne</button>

    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Liste des antennes</h3>
    </div>

<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>Region</th>
                    <th>Libelle</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @foreach($antennes as $antene)
                <tr>
                    <td>{{getlibelle($antene->region_id)}}</td>
                    <td>{{$antene->nom_de_lantenne}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                             {{-- @can('role.update', Auth::user()) --}}
                                <button  data-toggle="modal" onclick="edit_antenne({{ $antene->id }});"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" data-target="#update-antenne" ><i class="fa fa-edit"></i></a>
                            {{-- @endcan --}}
                            @can('role.delete',Auth::user())
                                <a href="#modal-confirm-delete" onclick="delConfirm({{ $antene->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                            @endcan
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Region</th>
                <th>Libelle</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
        </div>
@endsection
@section('modalSection')
<div class="modal fade" id="update-antenne">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modifier l'antenne</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('antenne.modifier') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="antenne_id" name="antenne_id">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="region">Region du centre<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="region_u" name="region" data-placeholder="Chosir Region Collecte .." value="{{old("region")}}" onchange="changeValue('region_u', 'province_u', {{ env('PARAMETRE_ID_PROVINCE') }});" required>
                                    <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                     @foreach ($regions as $region )
                                            <option value="{{ $region->id  }}" {{ old('region') == $region->id ? 'selected' : '' }}>{{ $region->libelle }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
             
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                        <label class=" control-label" for="libelle">Nom de l'antenne<span class="text-danger">*</span></label>
                        <input id="nom_de_lantenne_u" type="text"  class="form-control" name="libelle" max="40" placeholder="Entrer la de nomination de l'antenne" required autofocus>    
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
              <!-- textarea -->
              <div class="form-group">
                <label>Décrire l'antenne</label>
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
  <div class="modal fade" id="create-antenne">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ajouter une antenne</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('antenne.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="region">Region siege<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="region" name="region" data-placeholder="Chosir Region Collecte .." value="{{old("region")}}" onchange="changeValue('region', 'province', {{ env('PARAMETRE_ID_PROVINCE') }});" required>
                                    <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                     @foreach ($regions as $region )
                                            <option value="{{ $region->id  }}" {{ old('region') == $region->id ? 'selected' : '' }}>{{ $region->libelle }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Nom de l'antenne<span class="text-danger">*</span></label>
                            <input id="name" type="text"  class="form-control" name="libelle" max="40" placeholder="Entrer la denomination de l'antenne" required autofocus>    
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
              <!-- textarea -->
              <div class="form-group">
                <label>Décrire l'antenne</label>
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
    
    <script>

    function edit_antenne(id){
                var id=id;
                $('#region_u').prop('selectedIndex',0);
                $("#nom_de_lantenne_u").val();
                $("#description_u").val('');
            var url = "{{ route('antenne.getById') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        $('#antenne_id').val(data.id).change()
                        $("#region_u").val(data.region_id).change();
                        $("#nom_de_lantenne_u").val(data.nom_de_lantenne);
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

