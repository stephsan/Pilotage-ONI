@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('administration-permission', 'active')
@section('content')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card card-success col-md-8 col-md-offset-2">
                <div class="card-header">
                  <h3 class="card-title">Modifier une permission</h3>
                </div>
                <div class="card-body">
                    <form id="form-validation" method="POST"  action="{{route('permissions.update', $permission)}}" class="form-horizontal form-bordered">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="nom">Libelle de la permission<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="name" type="text" class="form-control" name="nom" value="{{$permission->name}}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('nom'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                                    <label class="col-md-6 control-label">Module<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select name="for" id="for" class="form-control"
                                    >
                                        <option selected disabled>Selectionne permission pour</option>
                                        <option value="administration">Administration</option>
                                        <option value="gestion">Gestion</option>
                                    </select>
                            </div>
                            </div>
                    <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                        <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    </div>
                </div>
                </form>
                </div>
                <!-- /.card-body -->
              </div>
            
        </div>
    </div>
@endsection
