@extends('backend.partials.main')
@section('tache', 'menu-open')
@section('tache_encours', 'active')
@section('content')

@section('content')
<div class="card card-success col-md-12 col-md-offset-2">
    {{-- <button  data-toggle="modal" class="btn btn-success col-md-2 pull-right mt-2" style="margin-bottom: 7px;" data-target="#create-centre"><span></span> Ajouter une nouvelle tache</button> --}}

    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Liste de mes taches</h3>
    </div>

<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>Type tache</th>
                    <th>Titre</th>
                    <th>Date Debut</th>
                    <th>Date Echéance</th>
                    <th>Statut</th>
                    <th>Progression</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @foreach($mes_taches as $tache)
                <tr>
                    <td>{{getlibelle($tache->type_id)}}</td>
                    <td>{{$tache->intitule}}</td>
                    <td>{{$tache->date_daffectation}}</td>
                    <td>{{$tache->deadline}}</td>
                    <td>{{getlibelle($tache->statut)}}</td>
                    <td> 
                        @if((Auth::user()->id==$tache->personne_id) && ($tache->statut ==env('ID_STATUT_NON_DEMARRE')))
                            En cours <label class="switch switch-success"> <input type="checkbox" id='encours' onchange="changeTaskStatus('{{ $tache->id }}','encours')"><span></span></label>
                            {{-- Terminé <label class="switch switch-danger"> <input type="checkbox" id='terminer1' onchange="changeTaskStatus('{{ $tache->id }}','terminer1')"><span></span></label> --}}

                        @elseif ((Auth::user()->id==$tache->creer_par) && ($tache->statut ==env('ID_STATUT_ENCOURS')))
                             Terminé <label class="switch switch-danger"> <input type="checkbox" id='terminer' onchange="changeTaskStatus('{{ $tache->id }}','terminer')"><span></span></label>
                        {{-- @elseif ($tache->statut ==env('ID_STATUT_TERMINE'))
                             Non demarre <label class="switch switch-success"> <input type="checkbox" id='non_demarre' onchange="changeTaskStatus('{{ $tache->id }}','non_demarre')"><span></span></label>
                        --}}
                        @endif 

                    </td>
                    <td class="text-center">
                            <div class="btn-group">
                             {{-- @can('role.update', Auth::user()) --}}
                                <button  data-toggle="modal" onclick="edit_tache({{ $tache->id }});"  data-toggle="tooltip" title="Modifier" class="btn btn-xs btn-default" data-target="#update-centre" ><i class="fa fa-edit"></i></a>
                            {{-- @endcan --}}
                            @can('role.delete',Auth::user())
                                <a href="#modal-confirm-delete" onclick="delConfirm({{ $tache->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                            @endcan
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Type tache</th>
                <th>Titre</th>
                <th>Date Debut</th>
                <th>Date Echéance</th>
                <th>Statut</th>
                <th>Progression</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
        </div>
        <div class="card card-success col-md-12 col-md-offset-2">
            <button  data-toggle="modal" class="btn btn-success col-md-2 pull-right mt-2" style="margin-bottom: 7px;" data-target="#create-centre"><span></span> Ajouter une nouvelle tache</button>
        
            <div class="card-header" style="margin-bottom: 10px;">
              <h3 class="card-title">Liste des taches que j'ai créé</h3>
            </div>
        
        <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
                <thead>
                        <tr>
                            <th>Type tache</th>
                            <th>Titre</th>
                            <th>Date Debut</th>
                            <th>Date Echéance</th>
                            <th>Porteur du dossier</th>
                            <th>Statut</th>
                            <th>Progression</th>
                            <th>Actions</th>
                        </tr>
                </thead>
                <tbody>
                    @foreach($taches_affectes as $tache)
                        <tr>
                            <td>{{getlibelle($tache->type_id)}}</td>
                            <td>{{$tache->intitule}}</td>
                            <td>{{$tache->date_daffectation}}</td>
                            <td>{{$tache->deadline}}</td>
                            <td>{{$tache->porteur->name}} {{ $tache->porteur->prenom}} - {{ $tache->porteur->fonction}}</td>
                            <td>{{getlibelle($tache->statut)}}</td>
                            <td>
                               @if ((Auth::user()->id==$tache->creer_par) && ($tache->statut ==env('ID_STATUT_ENCOURS')))
                                    Terminé <label class="switch switch-danger"> <input type="checkbox" id='terminer2' onchange="changeTaskStatus('{{ $tache->id }}','terminer2')"><span></span></label>
                                @endif
                         
                            </td>
                            <td class="text-center">
                                    <div class="btn-group">
                                     {{-- @can('role.update', Auth::user()) --}}
                                    @if(($tache->statut !=env('ID_STATUT_TERMINE')))
                                        <button  data-toggle="modal" onclick="edit_tache({{ $tache->id }});"  data-toggle="tooltip" title="Modifier" class="btn btn-xs btn-default" data-target="#update-centre" ><i class="fa fa-edit"></i></a>
                                    @endif
                                    @can('role.delete',Auth::user())
                                        <a href="#modal-confirm-delete" onclick="delConfirm({{ $tache->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                    @endcan
                                    </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Type tache</th>
                        <th>Titre</th>
                        <th>Date Debut</th>
                        <th>Date Echéance</th>
                        <th>Statut</th>
                        <th>Progression</th>
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
          <h4 class="modal-title">Modifier une tache</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('tache.modifier') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="id_tache" name="id_tache">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="antenne">Type tache<span class="text-success">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="type_tache_u" name="type_tache" data-placeholder="Chosir le type de tache .." value="{{old("tache")}}" >
                                    <option></option>
                                    <option value="null">Aucune</option>
                                        @foreach ($type_taches as $type_tache )
                                                <option value="{{ $type_tache->id}}" {{ old('type_tache') == $type_tache->id ? 'selected' : '' }}>{{ $type_tache->libelle }}</option>
                                        @endforeach
                                </select>
                        </div>
                    </div>
       
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('titre') ? ' has-error' : '' }}">
                    <label class=" control-label" for="titre">Titre de la tache<span class="text-danger">*</span></label>
                    <input id="titre_u" type="text"  class="form-control" name="titre" max="40" placeholder="Entrer le titre de la tache" required autofocus>    
                        @if ($errors->has('titre'))
                        <span class="help-block">
                            <strong>{{ $errors->first('titre') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6" >
                    <div class="form-group">
                      <label>Description de la tache</label>
                      <textarea class="form-control" id="description_u" name="description" rows="3" placeholder="Entrer une description de la tache ..." required></textarea>
                    </div>
            </div>
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Date Fin<span class="text-danger">*</span></label>
                    <input id="date_fin_u" type="text"  class="form-control date_tache" name="date_fin"  required autofocus>    
                        @if ($errors->has('date_fin'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_fin') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <label class="control-label" for="porteur">Affecté a<span class="text-success">*</span></label>
                        <select class="form-control select2" style="width: 100%;" id="porteur_u" name="porteur" data-placeholder="Chosir le porteur du dossier .." value="{{old("porteur")}}">
                            <option></option>
                                @foreach ($users as $user )
                                        <option value="{{ $user->id}}" {{ old('porteur') == $user->id ? 'selected' : '' }}>{{ $user->matricule }} - {{ $user->name }} {{ $user->prenom }} - {{ getlibelle($user->fonction) }}</option>
                                @endforeach
                        </select>
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
          <h4 class="modal-title">Ajouter une nouvelle tache</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('tache.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                {{-- <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}"> --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="antenne">Type tache<span class="text-success">*</span></label>
                                <select class="form-control select2" style="width: 100%;" id="type_tache" name="type_tache" data-placeholder="Chosir le type de tache .." value="{{old("tache")}}" >
                                    <option></option>
                                    <option value="null">Aucune</option>
                                        @foreach ($type_taches as $type_tache )
                                                <option value="{{ $type_tache->id}}" {{ old('type_tache') == $type_tache->id ? 'selected' : '' }}>{{ $type_tache->libelle }}</option>
                                        @endforeach
                                </select>
                        </div>
                    </div>
       
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('titre') ? ' has-error' : '' }}">
                    <label class=" control-label" for="titre">Titre de la tache<span class="text-danger">*</span></label>
                    <input id="titre" type="text"  class="form-control" name="titre" max="40" placeholder="Entrer le titre de la tache" required autofocus>    
                        @if ($errors->has('titre'))
                        <span class="help-block">
                            <strong>{{ $errors->first('titre') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6" >
                    <div class="form-group">
                      <label>Description de la tache</label>
                      <textarea class="form-control" id="description" name="description" rows="3" placeholder="Entrer une description de la tache ..." required></textarea>
                    </div>
            </div>
            <div class="col-md-6" >
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                    <label class=" control-label" for="libelle">Date Fin<span class="text-danger">*</span></label>
                    <input id="date_fin" type="text"  class="form-control date_tache" name="date_fin"  required autofocus>    
                        @if ($errors->has('date_fin'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_fin') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <label class="control-label" for="porteur">Affecté a<span class="text-success">*</span></label>
                        <select class="form-control select2" style="width: 100%;" id="porteur" name="porteur" data-placeholder="Chosir le porteur du dossier .." value="{{old("porteur")}}">
                            <option></option>
                                @foreach ($users as $user )
                                        <option value="{{ $user->id}}" {{ old('porteur') == $user->id ? 'selected' : '' }}>{{ $user->matricule }} - {{ $user->name }} {{ $user->prenom }} - {{ getlibelle($user->fonction) }}</option>
                                @endforeach
                        </select>
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
function changeTaskStatus(id,statut){
            //var val_btn= $("#encours").val();
            if ($('#'+statut).is(":checked")){
                var val_btn=1
            }else{
                val_btn=0
            }
            //alert(val_btn);
        var url = "{{ route('tache.changeStatus') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id, btn_val:val_btn} ,
                    error:function(){alert('error');},
                    success:function(data){
                        $('#'+statut).prop('checked', false); 
                        location.reload();
                    }
                });
}
    function edit_tache(id){
                var id=id;
                $("#titre_u").val('');
                $("#type_tache_u").val('');
                $("#titre_u").val('');
                $("#description_u").val('');
                $("#id_tache").val(id);
            var url = "{{ route('tache.getById') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        console.log(data)
                        $("#type_tache_u").val(data.type_id).change();
                        $("#statut_u").val(data.statut).change();
                        $("#description_u").val(data.description).change();
                        $("#titre_u").val(data.intitule);
                        $("#date_fin_u").val(data.deadline);
                        $("#porteur_u").val(data.personne_id).change();
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

