@extends('backend.partials.main')
@section('testlin', 'menu-open')
@section('mouvement', 'active')
@section('content')

@section('content')
<div class="card card-success col-md-12 col-md-offset-2">
    @can('enregistrer_dans_le_registre',Auth::user())
    <button  data-toggle="modal" class="btn btn-success col-md-2 pull-right mt-2" style="margin-bottom: 7px;" data-target="#create-ligne_mouvent"><span></span> Ajouter une ligne</button>
@endcan

    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Mouvements du testlin</h3>
    </div>

<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>Numero</th>
                    <th>Date</th>
                    <th>Référence</th>
                    <th>Antenne</th>
                    <th>Sorties</th>
                    <th>Retours</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
                @php
                    $i=0;
                @endphp
            @foreach($mouvement_teslins as $mouvement_teslin)
                @php
                    $i+=1;
                @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$mouvement_teslin->date}}</td>
                    <td>{{$mouvement_teslin->reference}}</td>
                    <td>{{$mouvement_teslin->antenne->nom_de_lantenne}}</td>
                    <td>{{$mouvement_teslin->qte_sortie}}</td>
                    <td>{{$mouvement_teslin->qte_entree}}</td>

                    <td class="text-center">
                            <div class="btn-group">
                            @can('modifier_le_registre',Auth::user())
                                <button  data-toggle="modal" onclick="edit_ligne_mouvement({{ $mouvement_teslin->id }});"  data-toggle="tooltip" title="Modifier" class="btn btn-xs btn-default" data-target="#update-registre" ><i class="fa fa-edit"></i></a>
                            @endcan
                             @can('role.delete',Auth::user())
                                <a href="#modal-confirm-delete" onclick="delConfirm({{ $mouvement_teslin->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
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
                <th>Référence</th>
                <th>Antenne</th>
                <th>Sorties</th>
                <th>Retours</th>
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
          <h4 class="modal-title">Modifier le mouvement du stock</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('testlin.modifier') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="testlin_id" id="testlin_id">
                <div class="row">
                    <div class="col-md-8" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Date <span class="text-danger">*</span></label>
                            <input id="date_u" type="text"  class="form-control date_affecte" name="date"  required autofocus>    
                                @if ($errors->has('date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="region">Antenne<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" name="antenne" id="antenne_u" data-placeholder="Selectionnez la nature de la recette.."  onchange="cacherSiValnatureRecette('nature_u','champ_cnib','autre_champ')" required>
                                    <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                    @foreach ($antennes as $antenne )
                                            <option value="{{ $antenne->id  }}" {{ old('ccd') == $antenne->id ? 'selected' : '' }}>{{ $antenne->nom_de_lantenne }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}">
                            <label class=" control-label" for="reference">Référence<span class="text-danger">*</span></label>
                            <input id="reference_u" type="text"  class="form-control" name="reference" min="0" placeholder="Entrer la référence" required autofocus>    
                                @if ($errors->has('reference'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('reference') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('qte_entree') ? ' has-error' : '' }}">
                            <label class=" control-label" for="qte_entree">Quantité en entrée<span class="text-danger">*</span></label>
                            <input id="qte_entree_u" type="number"  class="form-control" name="qte_entree" min="0" placeholder="Entrer la quantité entrée" required autofocus>    
                                @if ($errors->has('qte_entree'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('qte_entree') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('qte_sortie') ? ' has-error' : '' }}">
                                <label class="control-label" for="qte_sortie">Quantité en sortie<span class="text-danger">*</span></label>
                                <input id="qte_sortie_u" type="number"  class="form-control" name="qte_sortie" min="0" placeholder="Entrer la quantité sortie" required autofocus>    
                                    @if ($errors->has('qte_sortie'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('qte_sortie') }}</strong>
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
  <div class="modal fade" id="create-ligne_mouvent">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ajouter un mouvement du teslin</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-validation" method="POST"  action="{{ route('testlin.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-8" >
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class=" control-label" for="libelle">Date <span class="text-danger">*</span></label>
                            <input id="date_effet" type="text"  class="form-control date_affecte" name="date"  required autofocus>    
                                @if ($errors->has('date_effet'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date_effet') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="antenne">Antenne<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" name="antenne" id="antenne_u" data-placeholder="Selectionnez la nature de la recette.."   required>
                                    <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                    @foreach ($antennes as $antenne )
                                            <option value="{{ $antenne->id  }}" {{ old('ccd') == $antenne->id ? 'selected' : '' }}>{{ $antenne->nom_de_lantenne }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}">
                            <label class=" control-label" for="reference">Référence<span class="text-danger">*</span></label>
                            <input id="reference" type="text"  class="form-control" name="reference" min="0" placeholder="Entrer la référence" required autofocus>    
                                @if ($errors->has('reference'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('reference') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('qte_entree') ? ' has-error' : '' }}">
                            <label class=" control-label" for="qte_entree">Quantité en entrée<span class="text-danger">*</span></label>
                            <input id="qte_entree" type="number"  class="form-control" name="qte_entree" min="0" placeholder="Entrer la quantité entrée" required autofocus>    
                                @if ($errors->has('qte_entree'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('qte_entree') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('qte_sortie') ? ' has-error' : '' }}">
                                <label class=" control-label" for="qte_sortie">Quantité en sortie<span class="text-danger">*</span></label>
                                <input id="qte_sortie" type="number"  class="form-control" name="qte_sortie" min="0" placeholder="Entrer la quantité sortie" required autofocus>    
                                    @if ($errors->has('qte_sortie'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('qte_sortie') }}</strong>
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
 
    function edit_ligne_mouvement(id){
                var id=id;
                $("#testlin_id").val(id);
            var url = "{{ route('mouvement_testlin.getById') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        //console.log(data)
                        $("#date_u").val(data.date);
                        $("#reference_u").val(data.reference);
                        $("#qte_entree_u").val(data.qte_entree);
                        $("#qte_sortie_u").val(data.qte_sortie);
                        $("#antenne_u").val(data.antenne_id).change();

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

