@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('user', 'active')
@section('content')
        <div class="row">
                    <div class="card card-success col-md-12 col-md-offset-2">
                        <a href="{{ route('user.create') }}" class="btn btn-success col-md-2" type="button" ><span><i class="fa fa-plus"></i></span> User</a>

                        <div class="card-header">
                          <h3 class="card-title">Liste des utilisateurs</h3>
                        </div>

                        {{-- <a  class="btn btn-block btn-success col-md-2 mt-2" type="button"><span><i class="fa fa-plus"></i></span>User</a> --}}
                     
<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Antenne</th>
                    <th>Email</th>
                    <th>Tel</th>                
                    <th >Action</th>
                </tr>
        </thead>
        <tbody>
                @php
                $i=0;
                    @endphp
                 @foreach($users as $user)
                @php
                $i++;
                @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->Prenom}}</td>
                    <td>{{$user->antenne_id}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{ $user->Telephone}}</td>
                    {{-- <td>{{ $user->antenne->nom_de_lantenne}}</td> --}}
                    {{-- <td class="col-md-1">
                        <label class="switch switch-danger "><input type="checkbox" onclick="idstatus({{ $user->id }})"
                             @if($user->status == 1)
                                checked
                            @endif
                            value="1"><span></span></label>
                    </td> --}}
                    <td class="text-center">
                         
                            <div class="btn-group">
                                <a href="{{ route('user.edit',$user) }}" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                            </div>
                            <div class="btn-group">
                                <a href="#modal-user-reinitialise" data-toggle="modal" title="télécharger" class="btn btn-xs btn-success"  onclick="recup_id('{{$user->id}}')"><i class="fa fa-repeat"></i>  </a>
                            </div>
                        
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>

@endsection
@section('modalSection')

<div id="modal-user-reinitialise" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Reinitialiser le mot de passe</h2>
            </div>
            <!-- END Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body form-bordered">

                        <div>
                            <p>Voulez-vous vraiment reinitialiser le mot de passe de l'utilisateur? Un mot de passe aleatoire sera envoye par mail.</p>
                        </div>
                        <input type="hidden" name="user_pass" id="id_user_pass">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-sm btn-warning" onclick="reinitialise_password();">Reinitialiser</button>
                        </div>

            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<!-- Voir details users -->
<div id="modal-voir-detail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-pencil"></i>Details de l'utilisateur</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body form-bordered">
                        <div class="row col-md-offset-2">
                            <label class="col-md-3 control-label">NOM</label> <div class="col-md-8"><span id="nom_user"></span></div>
                        </div>

                        <div class="row col-md-offset-2">
                            <label class="col-md-3 control-label">PRENOM</label> <div class="col-md-8"> <span  id="prenom_user"></span></div>
                        </div>

                        <div class="row col-md-offset-2">
                                <label class="col-md-3 control-label">EMAIL</label> <div class="col-md-8"> <span  id="email_user"></span></div>
                        </div>
                        <div class="row col-md-offset-2">
                                <label class="col-md-3 control-label">TELEPHONE</label> <div class="col-md-8"> <span  id="telephone_user"></span></div>
                        </div>

                        <div class="row col-md-offset-2">
                                <label class="col-md-3 control-label">Login</label> <div class="col-md-8"> <span  id="login_user"></span></div>
                        </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                            </div>

                </div>
                <!-- END Modal Body -->
            </div>
        </div>
</div>
{{-- Modal de confirmation de reinitialisation de mot de passe user --}}
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
                            <p>Voulez-vous vraiment Supprimer l'utilisateur</p>
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
{{-- modal de confiramation de suppression  d'un utilisateur --}}
<div id="modal-confirm-delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-pencil"></i> Confirmation</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">

                            <div>
                            </div>
                            <p>Voulez-vous vraiment Supprimer l'utilisateur ???</p>
                        <div class="form-group form-actions">
                            <div class="col-xs-12 text-right">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-sm btn-primary">OUI</button>
                            </div>
                        </div>

                </div>
                <!-- END Modal Body -->
            </div>
        </div>
    </div>
    {{-- cette fonction javascript permet de definir l'action du formulaire dynamiquement. l'action route user reinitialise dans le formulaire dont id est reini_user --}}
    <script>
    function detailUser(id){
                var id=id;
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                       $("#nom_user").text(data.nomUser);
                       $("#prenom_user").text(data.prenomUser);
                       $("#email_user").text(data.emailUser);
                       $("#telephone_user").text(data.telephone);
                       $("#login_user").text(data.login);
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
        function delConfirm (id){
            //alert(id);
            $(function(){
                //alert(id);
                document.getElementById("id_table").setAttribute("value", id);
            });

        }
        function recup_id(id){
                //console.log(id);
                document.getElementById('id_user_pass').setAttribute("value", id);
        }
        function reinitialise_password(user){
            $(function(){
                var id= $("#id_user_pass").val();
                var url = "{{ route('user.reinitialize') }}";
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


