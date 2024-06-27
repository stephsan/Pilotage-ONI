@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('administration-entite', 'active')
@section('content')

@section('content')
<div class="card card-success col-md-12 col-md-offset-2">
    <button  data-toggle="modal" class="btn btn-success col-md-2 pull-right mt-2" style="margin-bottom: 7px;" data-target="#create-centre"><span></span> Ajouter une Entite</button>

    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Liste des entites</h3>
    </div>

<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>Numero</th>
                    <th>intitulé</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @foreach($entites as $entite)
                <tr>
                    <td>{{$entite->id}}</td>
                    <td>{{$entite->intitule}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                             {{-- @can('role.update', Auth::user()) --}}
                                <button  data-toggle="modal" onclick="edit_entite({{ $entite->id }});"  data-toggle="tooltip" title="Modifier" class="btn btn-xs btn-default" data-target="#update-centre" ><i class="fa fa-edit"></i></a>
                            {{-- @endcan --}}
                            @can('role.delete',Auth::user())
                                <a href="#modal-confirm-delete" onclick="delConfirm({{ $entite->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                            @endcan
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Numero</th>
                <th>intitulé</th>
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
          <h4 class="modal-title">Modifier une entite</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('entite.modifier') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="id_entite" name="entite_id">
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}} 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="antenne">Entite parent<span class="text-success">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="entite_u" name="entite" data-placeholder="Chosir l'entites .." value="{{old("entite")}}">
                                    <option></option>
                                    <option value="null">Aucune</option>
                                        @foreach ($entites as $entite )
                                                <option value="{{ $entite->id}}" {{ old('entite') == $entite->id ? 'selected' : '' }}>{{ $entite->intitule }}</option>
                                        @endforeach
                                </select>
                        </div>
                    </div>
       
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Intitulé de l'entité<span class="text-danger">*</span></label>
                    <input id="libelle_u" type="text"  class="form-control" name="libelle" max="40" placeholder="Entrer le nom de l'entite" required autofocus>    
                        @if ($errors->has('libelle'))
                        <span class="help-block">
                            <strong>{{ $errors->first('libelle') }}</strong>
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
          <h4 class="modal-title">Ajouter une nouvelle entité</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('entite.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="antenne">Entite parent<span class="text-success">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="entite" name="entite" data-placeholder="Chosir l'entites .." value="{{old("entite")}}" >
                                    <option></option>
                                    <option value="null">Aucune</option>
                                        @foreach ($entites as $entite )
                                                <option value="{{ $entite->id}}" {{ old('entite') == $entite->id ? 'selected' : '' }}>{{ $entite->intitule }}</option>
                                        @endforeach
                                </select>
                        </div>
                    </div>
       
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Intitulé de l'entité<span class="text-danger">*</span></label>
                    <input id="libelle_u" type="text"  class="form-control" name="libelle" max="40" placeholder="Entrer le nom de l'entite" required autofocus>    
                        @if ($errors->has('libelle'))
                        <span class="help-block">
                            <strong>{{ $errors->first('libelle') }}</strong>
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

    function edit_entite(id){
                var id=id;
                $("#intitule_u").val('');
                $("#entite_u").val('');
                $("#id_entite").val(id);
            var url = "{{ route('entite.getById') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        console.log(data)
                        $("#entite_u").val(data.entite_id).change();
                        $("#libelle_u").val(data.intitule);
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

