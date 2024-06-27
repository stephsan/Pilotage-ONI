@extends('backend.partials.main')
@section('administration', 'menu-open')
@section('administration-role', 'active')
@section('content')
{{-- @section('blank')
    <li>Accueil</li>
    <li>Roles</li>
    <li><a href="">liste</a></li>
@endsection --}}
    @section('content')
    <div class="container">
        <div class="row">
            <div class="card card-success col-md-8 col-md-offset-2">
                <div class="card-header">
                  <h3 class="card-title">Créer un rôle</h3>
                </div>
                <div class="card-body">
                    <form id="form-validation" method="POST"  action="{{route('role.store')}}" class="form-horizontal form-bordered">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="name">Libellé du role<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                        <input id="name" type="text" class="form-control" name="nom" value="{{ old('nom') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('nom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- {{-- <div class="form-group">
                            <label class="col-md-4 control-label"> Role Système <span class="text-success">*</span></label>
                        <div class="col-md-8">
                            <div class="input-group">
                                    <input type="checkbox"  class="form-control" name="typeRole" value="1">
                            </div>
                        </div>
                    </div> --}} -->
                        <div class="row col-lg-offset-1">
                                <!-- <div class="col-lg-4">
                                    <label><u>Permissions système</u></label>
                                    @foreach ($permissions as $permission )
                                        @if($permission->for== 'systeme')
                                                <label><input type="checkbox" name=permission[] value="{{ $permission->id }}"> {{ $permission->name }}</label>
                                        @endif
                                    @endforeach
                                </div> -->
                                <!-- <div class="col-lg-4 ">
                                        <label> <u>Permissions Dossier</u></label>
                                        @foreach ($permissions as $permission )
                                            @if($permission->for== 'dossier')
                                                    <label><input type="checkbox" name=permission[] value="{{ $permission->id }}"> {{ $permission->name }}</label>
                                            @endif
                                        @endforeach
                                </div> -->
                                <div class="col-lg-4 ">
                                    <label> <u>Permissions Administration</u></label>
                                    @foreach ($permissions as $permission )
                                        @if($permission->for== 'administration')
                                                <label><input type="checkbox" name=permission[] value="{{ $permission->id }}"> {{ $permission->name }}</label>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-lg-4 ">
                                    <label> <u>Permissions Demande</u></label>
                                    @foreach ($permissions as $permission )
                                        @if($permission->for== 'inscription')
                                                <label><input type="checkbox" name=permission[] value="{{ $permission->id }}"> {{ $permission->name }}</label>
                                        @endif
                                    @endforeach
                                </div>
                        </div>
                    <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                        <a href="{{ route('role.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    </div>
                </div>
                </form>
                </div>
                <!-- /.card-body -->
              </div>
           
        </div>
    </div>
@endsection
