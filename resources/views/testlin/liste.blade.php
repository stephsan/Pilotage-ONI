@extends('backend.partials.main')
@section('testlin', 'menu-open')
@section('mouvement', 'active')
@section('content')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header border-0">
          <h3 class="card-title"><center>Situation des teslins</center></h3>
          <div class="card-tools">
            <a href="#" class="btn btn-tool btn-sm">
              <i class="fas fa-download"></i>
            </a>
            <a href="#" class="btn btn-tool btn-sm">
              <i class="fas fa-bars"></i>
            </a>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
              <th>Total Entrées </th>
              <th>Total Sorties</th>
              <th>Total Retours</th>
              <th>Stock Théorique</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $mouvement_teslins_entrees->sum('quantite')}}</td>
                <td>{{ $mouvement_teslins_sorties->sum('quantite')}}</td>
                <td>{{ $mouvement_teslins_retours->sum('quantite')}}</td>
                <td>{{ $stock_theorique}}</td>
                <td>
                </td>
            </tr>
            </tbody>
          </table>
        </div>
    </div>

</div>
<div class="card card-success col-md-12 col-md-offset-2">
    @can('gerer_teslin',Auth::user())
    <button  data-toggle="modal" class="btn btn-success col-md-2 pull-right mt-2" style="margin-bottom: 7px;" data-target="#create-ligne_mouvent"><span></span> Ajouter un mouvement</button>
@endcan
    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Mouvements du testlin</h3>
    </div>

<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr>
                    
                    <th>Numero</th>
                    <th>Type d'opération</th>
                    <th>Date</th>
                    <th>Référence</th>
                    <th>Antenne</th>
                    <th>Quantité</th>
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
                    <td>{{$mouvement_teslin->type_operation}}</td>
                    <td>{{$mouvement_teslin->date}}</td>
                    <td>{{$mouvement_teslin->reference}}</td>
                    <td>{{$mouvement_teslin->antenne->nom_de_lantenne}}</td>
                    <td>{{$mouvement_teslin->quantite}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                            @can('gerer_teslin',Auth::user())
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
                <th>Type d'opération</th>
                <th>Date</th>
                <th>Référence</th>
                <th>Antenne</th>
                <th>Quantité</th>
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
                <input type="hidden" name="old_quantite" id="old_quantite">
                <input type="hidden" value={{ $stock_theorique }} id="stock_theorique">
                <div class="row">
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label class="control-label" for="region">Type d'opération<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" name="type_operation" id="type_operation_u" data-placeholder="Selectionnez le type d'opération.."   onchange="controle_type_operation('type_operation_u','antenne_u');" >
                                    <option></option>
                                        <option value="entree">Entree dans le stock principal</option>
                                        <option value="sortie">Affectation a une antenne</option>
                                        <option value="retour">Retour d'une antenne</option>
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6" >
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
                    <div class="col-md-6 antenne_input">
                        <div class="form-group">
                            <label class="control-label" for="region">Antenne<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" name="antenne" id="antenne_u" data-placeholder="Selectionnez la nature de la recette.."  required>
                                    <option></option>
                                    @foreach ($antennes as $antenne )
                                            <option value="{{ $antenne->id  }}" {{ old('antenne') == $antenne->id ? 'selected' : '' }}>{{ $antenne->nom_de_lantenne }}</option>
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
                    <div class="col-md-8">
                        <div class="form-group{{ $errors->has('quantite') ? ' has-error' : '' }}">
                            <label class="control-label" for="quantite">Quantité<span class="text-danger">*</span></label>
                            <input id="quantite_u" type="number"  class="form-control" name="quantite" min="0" placeholder="Entrer la quantité" onchange="controle_quantite('type_operation_u','quantite_u',1)" required autofocus>    
                                @if ($errors->has('quantite'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('quantite') }}</strong>
                                </span>
                                @endif
                            </div>
                            <p class="message_alert_quantite_controle" style="color: red; display:none">Vous ne pouvez pas faire la sortie de cette quantité</p>

                    </div>
                </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-success save_btn"><i class="fa fa-arrow-right"></i> Enregistrer</button>
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
                <div class="col-md-6" >
                    <div class="form-group">
                        <label class="control-label" for="type_operation">Type d'opération<span class="text-danger">*</span></label>
                            <select class="form-control select2" style="width: 100%;" name="type_operation" id="type_operation" data-placeholder="Selectionnez le type d'opération.."  onchange="controle_type_operation('type_operation','antenne');" required>
                                <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                    <option value="entree">Entree dans le stock principal</option>
                                    <option value="sortie">Affectation a une antenne</option>
                                    <option value="retour">Retour d'une antenne</option>
                            </select>
                    </div>
                </div>  
                    <div class="col-md-6" >
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
                    <div class="col-md-6 antenne_input">
                        <div class="form-group">
                            <label class="control-label" for="antenne">Antenne<span class="text-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%;" name="antenne" id="antenne_u" data-placeholder="Selectionnez la nature de la recette..">
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
                    <div class="col-md-8 col-md-offset-2">
                        <div class="form-group{{ $errors->has('quantite') ? ' has-error' : '' }}">
                            <label class=" control-label" for="quantite">Entrer la quantité<span class="text-danger">*</span></label>
                            <input id="quantite" type="number"  class="form-control" name="quantite" min="0" placeholder="Entrer la quantité" onchange="controle_quantite('type_operation','quantite',0)" required autofocus>    
                                @if ($errors->has('quantite'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('quantite') }}</strong>
                                </span>
                                @endif
                            </div>
                            <p class="message_alert_quantite_controle" style="color: red; display:none">Vous ne pouvez pas faire la sortie de cette quantité</p>
                    </div>
                    </div>   
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default " data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-success save_btn"><i class="fa fa-arrow-right"></i> Enregistrer</button>
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
                </div>
            </div>
    </div>
    @endsection
    <script>
    function controle_type_operation(type_operation){
        type_operation= $("#"+type_operation).val();
        if(type_operation=='entree'){
            $(".antenne_input").hide();
        }
        else{
            $(".antenne_input").show();
        }
    }
    function controle_quantite(type_operation,champ,modif){
        var type_operation= $("#"+type_operation).val();
        var valeur_saisie= parseInt($("#"+champ).val());
        var old_value= parseInt($("#old_quantite").val());
        var result=0;
        var stock_theorique=parseInt($("#stock_theorique").val());
        //alert((type_operation))
        if(type_operation==null){
            alert("bien vouloir renseigner le type de l'operationd'abord")
        }
        else{
            if(type_operation=='sortie'){
                if(modif==0){
                   // alert(result)
                    (valeur_saisie > stock_theorique)?result=1:result=0;
                }
                else if(modif==1){
                   // alert(result)
                    (valeur_saisie > stock_theorique + old_value)?result=1:result=0;
                }
                
                if(result==1){
                    $(".save_btn").prop('disabled', true);
                    $('.message_alert_quantite_controle').show();
                }
                else{
                    $(".save_btn").prop('disabled', false);
                    $('.message_alert_quantite_controle').hide();
                }
            }
            else{
                $(".antenne_input").show();
            }

        }

    }
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
                        $("#date_u").val(data.date);
                        $("#reference_u").val(data.reference);
                        $("#quantite_u").val(data.quantite);
                        $("#old_quantite").val(data.quantite);
                        $("#antenne_u").val(data.antenne_id).change();
                        $("#type_operation_u").val(data.type_operation).change();
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



