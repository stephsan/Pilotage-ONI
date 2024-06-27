@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('administration-valeur', 'active')
@section('content')
<div class="block-title">
    <center><h3><strong>Ajouter une valeur</strong></h3></center>                    
</div>
                <div class="card-body">
                    <div class="table table-bordered table-striped">
                        <form action="{{ route('valeur.update', $valeur) }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
            
                                <div class="form-group{{ $errors->has('Parametre') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="typeorga">Parametre : </label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select  class="form-control" id="parent" name="parametre"  >
                                            <option></option>
            
                                            @foreach($parametres as $parametre)
                                                    <option value="{{ $parametre->id }}"
                                                        @if ($parametre->id == $valeur->parametre_id)
                                                            selected
                                                        @endif
                                                        >{{ $parametre->libelle }}</option>
                                             @endforeach
            
                                        </select>     </div>
                                    @if ($errors->has('parent'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('parent') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="typeorga">Parent : </label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select  class="form-control" id="parent" name="parent"  >
                                            <option></option>
            
                                            @foreach($vals as $val)
                                                <option value="{{ $val->id }}"
                                                   @if ($valeur->id == $val->val_id)
                                                        selected
                                                   @endif
                                                    >{{ $val->libelle }}</option>
                                            @endforeach
            
                                        </select>     </div>
                                    @if ($errors->has('parent'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('parent') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('libele') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="libele">Libellé : <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="libele" type="text" class="form-control" name="libelle" value="{{ old('libele')?? $valeur->libelle }}" required>
            
                                    </div>
                                    @if ($errors->has('libele'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('libele') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="description">Description : <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                        <textarea id="description" name="description" placehorder="description" class="form-control">{{old('description')?? $valeur->libelle}}</textarea>
                                        </div>
                                @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                            <div class="form-group form-actions">
                                <div class="col-md-9 col-md-offset-3">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Modifier</button>
                                   <a href="{{ route('valeur.index') }}" class="btn btn-sm btn-warning">Annuler</a>
                                </div>
                            </div>
                        </form>
                </div>                
@endsection
