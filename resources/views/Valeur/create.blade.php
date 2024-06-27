@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('administration-valeur', 'active')
@section('content')
<div class="block-title">
    <center><h3><strong>Modifier une valeur</strong></h3></center>                    
</div>
                <div class="card-body">
                    <div class="table table-bordered table-striped">
                    <form id="form-validation" method="POST"  action="{{route('valeur.store')}}" class="form-horizontal form-bordered">
                        {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="typeorga">Parametre <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select  class="form-control" id="parent" name="parametre" required autofocus>
                                            <option></option>
                                            @foreach($parametres as $parametre)
                                                <option value="{{ $parametre->id }}">{{ $parametre->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('parent'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('parent') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="typeorga">valeur parent : </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select  class="form-control" id="parent" name="parent"  >
                                <option></option>

                                @foreach($valeurs as $valeur)
                                    <option value="{{ $valeur->id }}">{{ $valeur->libelle }}</option>
                                @endforeach

                            </select>     </div>
                        @if ($errors->has('parent'))
                        <span class="help-block">
                            <strong>{{ $errors->first('parent') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="nom">libellé<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="name" type="text" class="form-control" name="libelle" value="{{ old('libelle') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('libelle'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('libelle') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="nom">Description<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="name" type="text" class="form-control" name="description" value="{{ old('description') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div> 
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="nom">Code</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="name" type="text" class="form-control" name="code" value="{{ old('code') }}">
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                    <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                        <a href="{{ route('valeur.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    </div>
                </div>
                </form>
                </div>                
@endsection
