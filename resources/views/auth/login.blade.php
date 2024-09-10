@extends('layouts/admin')
@section('page-content')

<div class="bg-login mx-0 py-5">
    <div class="wrapper">
    <div class="row">
        <div class="col-10 col-sm-8 col-md-6 col-lg-4 offset-1 offset-sm-2 offset-md-3 offset-lg-4">
            <div class="card mt-2">
            <div class="card-body">
                @if(session()->has('succes'))
                <div class="alert alert-success">{{session()->get('succes')}}</div>
                @endif
                @if(session()->has('error'))
                <div class="alert alert-danger">{{session()->get('error')}}</div>
                @endif
            <form action="{{ route('login') }}" method="post" class="form-product">
                    @method('post')
                    @csrf
                    <div class="text-center">
                       <!-- <img src="{{asset('/adminlte/logo-oni.png')}}" alt="Logo" class="logo text-center"/>-->
                        <img src="{{asset('/adminlte/logo-oni.png')}}" alt="Logo" class="logo text-center"/>
                    </div>
                    <h2 class="mb-3 text-center text-success" style="font-style: italic">Outils de pilotage de l'ONI </h2>

                    <div class="divider p-divider"></div>

                    <div class="form-group mb-1">
                        <label class="col-form-label" for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Entrer votre email" value="{{old('email')}}">
                        @error('email')
                            <div class="text text-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label class="col-form-label" for="password">Mot de passe</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Entrer votre mot de passe" value="">
                        @error('password')
                            <div class="text text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Se connecter</button>
                </form>
                </div>
            </div>
        </div>
</div>
    </div>
</div>

@endsection