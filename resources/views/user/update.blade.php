@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('user', 'active')

@section('content')
<div class="container">
    <div class="row">
        <div class="card card-success col-md-12 col-md-offset-2">
            <div class="card-header">
              <h3 class="card-title">Modifier un utilisateur</h3>
            </div>
            <div class="card-body">
                <form id="form-validation" method="POST"  action="{{route('user.update', $user)}}" class="form-horizontal form-bordered">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                <fieldset>
                    <legend><i class="fa fa-angle-right"></i>Informations personnelles</legend>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label" for="val_username">Nom<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <div class="input-group">
                                    <input id="name" type="text" class="form-control" name="nom" value="{{ $user->name}}" required autofocus>
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            </div>
                            @if ($errors->has('nom'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nom') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('prename') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="prenom">Prenom <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                        <input id="name" type="text" class="form-control" name="prenom" value="{{ $user->Prenom}}" required autofocus>
                                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('prenom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('prenom') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>                    
                    <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="telephone">Telephone<span class="text-success">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input  type="text" class="form-control" name="telephone" value="{{ $user->Telephone}}" required autofocus>
                                    <span class="input-group-addon"><i class="gi gi-earphone"></i></span>
                                </div>
                                @if ($errors->has('telephone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('telephone') }}</strong>
                                </span>
                                @endif
                            </div>
                     </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label" for="val_email">Email <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                                <div class="input-group">
                                        <input id="val_email" name="email" type="text" class="form-control" name="email" value="{{ $user->email}}" required autofocus placeholder="test@example.com">
                                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                </div>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                        </div>
                    </div>
                   <div class="form-group{{ $errors->has('organisation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="organisation">Antenne<span class="text-success">*</span></label>
                            <div class="col-md-6">
                                    <div class=" col-md-12 input-group ">
                                        <select  id="antenne" name="antenne" class="form-control select2">
                                                <option value="00100">Coordination</option>
                                                @foreach ($antennes as $antenne)
                                                    <option value="{!!old('organisation') ?? $antenne->id!!}"
                                                            @if ($user->antenne_id==$antenne->id)
                                                                        selected
                                                            @endif>{{ $antenne->nom_de_lantenne}}
                                                    </option>

                                                    @endforeach
                                                </select>
                                    </div>
                                        @if ($errors->has('organisation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('organisation') }}</strong>
                                        </span>
                                        @endif

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="region">L'entité de l'utilisateur <span class="text-success">*</span></label>
                                        <select class="form-control select2" style="width: 100%;" id="antenne_u" name="entite" data-placeholder="Selectionner l'entite dont releve l'utilisateur .." >
                                            <option></option>
                                            <option value="null">Aucune</option>
                                            @foreach ($entites as $entite )
                                                    <option value="{{ $entite->id  }}" {{ old('entite') == $entite->id ? 'selected' : '' }}
                                                        @if ($user->entite_id==$entite->id)
                                                                        selected
                                                            @endif>{{ $entite->intitule }}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                    </div>
                </fieldset>
                {{-- <div class="form-group">
                        <label class="col-sm-4">Activer</label>
                        <label class="switch switch-primary col-sm-1"><input type="checkbox" name="status"
                        @if($user->status == 1)
                            checked
                            @endif
                        value="1"><span></span></label>
                </div> --}}
                <fieldset>
                        <legend><i class="fa fa-angle-right"></i> Roles</legend>

                        <div class="form-group">
                            @foreach ($roles as $role)
                                <div class="col-lg-3">
                                   <label><input type="checkbox"name='roles[]' value="{{ $role->id }}"
                                            @foreach ($user->roles as $user_role )
                                                @if ($user_role->id==$role->id)
                                                    checked
                                                @endif
                                            @endforeach
                                    > {{ $role->nom }}</label>
                                </div>
                            @endforeach
                        </div>
                </fieldset>
                <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Modifier</button>
                        <a href="{{ route('user.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    </div>
                </div>
            </form>
            </div>
            <!-- /.card-body -->
          </div>
        
    </div>
</div>
@endsection
