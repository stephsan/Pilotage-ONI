@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('administration-permission', 'active')
@section('content')
<div class="card card-success col-md-12 col-md-offset-2">
    <div class="card-header">
      <h3 class="card-title">Liste des Permissions</h3>
    </div>
    <a href="{{ route('permissions.create') }}" class="btn btn-success col-md-2 pull-right mt-2"><span><i class="fa fa-plus"></i></span>Permission</a>

<div class="table-responsive">
    <table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>Libelle</th>
                    <th>Action</th>
                </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>{{$permission->name}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('permissions.edit', $permission) }}" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-edit"></i></a>
                                <a href="#modal-confirm-delete" onclick="delConfirm({{ $permission->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
@section('modalSection')

{{-- modal de confiramation de suppression  d'un utilisateur --}}
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
                            <p>Voulez-vous vraiment Supprimer cette permission ??</p>
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
    {{-- cette fonction javascript permet de definir l'action du formulaire dynamiquement. l'action route user reinitialise dans le formulaire dont id est reini_user --}}
    <script>

        function delConfirm (id){
            //alert(id);
            $(function(){
                //alert(id);
                document.getElementById("id_table").setAttribute("value", id);
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


