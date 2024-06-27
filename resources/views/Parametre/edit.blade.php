@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('administration-parametre', 'active')
@section('content')
<div class="block-title">
    <center><h3><strong>Modifier un paramètre</strong></h3></center>                    
</div>
                <div class="card-body">
                    <div class="table table-bordered table-striped">
                    <form action="{{ route('parametre.update', $parametre) }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-bordered">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="typeorga">Parametre parent : </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select  class="form-control" id="parent" name="parent"  >
                                        <option></option>
                                        @foreach($params as $param)
                                            <option value="{{ $param->id }}"
                                               @if ($parametre->id == $param->par_id)
                                                    selected
                                               @endif
                                                >{{ $param->libelle }}</option>
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
                                        <input id="libele" type="text" class="form-control" name="libelle" value="{{$parametre->libelle }}" required>
        
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
                                    <textarea id="description" name="description" placehorder="description" class="form-control">{{old('description')?? $parametre->libelle}}</textarea>
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
                               <a href="{{ route('parametre.index') }}" class="btn btn-sm btn-warning">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>                
@endsection
