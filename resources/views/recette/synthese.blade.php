@extends('backend.partials.main')
@section('recette', 'menu-open')
@section('recette-synthese', 'active')
@section('content')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header border-0">
          <h3 class="card-title"><center>Situation des recettes par mois</center></h3>
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
              <th>Mois</th>
              <th>Recette CNIB </th>
              <th>Recette DAO</th>
              <th>Recette Reversement</th>
              <th>Autre recette</th>
              <th>Total Recette</th>
            </tr>
            </thead>
            <tbody>
                @foreach($recettes_par_mois as $recettes_par_moi)
            <tr>
                <td>{{ get_month_french($recettes_par_moi->month)}}</td>
                <td>{{ format_prix($recettes_par_moi->cnib)}}</td>
                <td>{{ format_prix($recettes_par_moi->DAO)}}</td>
                <td>{{ format_prix($recettes_par_moi->reversement)}}</td>
                <td>{{ format_prix($recettes_par_moi->autre)}}</td>
                <td>{{ format_prix($recettes_par_moi->total)}}</td>
                <td>
                </td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
    </div>

</div>
<div class="card card-success col-md-12 col-md-offset-2">
    <div class="row">
    </div>
    
    <div class="card-header" style="margin-bottom: 10px;">
      <h3 class="card-title">Recette par région</h3>
    </div>

<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>Region</th>
                    <th>Recette CNIB </th>
                    <th>Recette DAO</th>
                    <th>Recette Reversement</th>
                    <th>Autre recette</th>
                    <th>Total Recette</th>
                </tr>
        </thead>
        <tbody>
            @foreach($recettes_regions as $saisie_annee_encour)
                <tr>
                    <td>{{ $saisie_annee_encour->region}}</td>
                <td>{{ format_prix($saisie_annee_encour->cnib)}}</td>
                <td>{{ format_prix($saisie_annee_encour->DAO)}}</td>
                <td>{{ format_prix($saisie_annee_encour->reversement)}}</td>
                <td>{{ format_prix($saisie_annee_encour->autre)}}</td>
                <td>{{ format_prix($saisie_annee_encour->total)}}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Region</th>
                <th>Recette CNIB </th>
                <th>Recette DAO</th>
                <th>Recette Reversement</th>
                <th>Autre recette</th>
                <th>Total Recette</th>
            </tr>
        </tfoot>
    </table>
</div>
</div>

@endsection
@section('modalSection')

    <script>

    </script>

@endsection

