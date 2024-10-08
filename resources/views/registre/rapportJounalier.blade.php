@extends('backend.partials.main')
@section('formulaire', 'menu-open')
@section('saisie', 'active')
@section('content')
<form action="{{ route('registre.rapport_journalier_bydate') }}" method="post">
<div class="row">
    @csrf
  <div class="col-md-8">
    <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
      <label class=" control-label" for="libelle">Renseignez la date<span class="text-danger">*</span></label>
      <input id="date_siege_u" type="text"  class="form-control date_affecte" name="date_concernee"  required autofocus>    
          @if ($errors->has('date_concernee'))
          <span class="help-block">
              <strong>{{ $errors->first('date_concernee') }}</strong>
          </span>
          @endif
    </div>
  </div>
  {{-- <div class="col-md-4">
    <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
      <label class=" control-label" for="libelle">Date Fin <span class="text-danger">*</span></label>
      <input id="date_siege_u" type="text"  class="form-control date_affecte" name="date_siege"  required autofocus>    
          @if ($errors->has('date_affecte'))
          <span class="help-block">
              <strong>{{ $errors->first('date_affecte') }}</strong>
          </span>
          @endif
    </div>
  </div> --}}
  <div class="col-md-3">
    <button type="submit"  class="btn btn-success" style="margin-top: 32px;"   href="#"><span></span> Rechercher</button>
    {{-- <a  data-toggle="modal" class="btn btn-warning" style="margin-top: 32px;"   href="#"><span></span> Imprimer</a> --}}
  </div>

</div>
</form>
        <div class="row">
            @foreach ($rapport_productions as $rapport_production )
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Service CNIB - {{ $rapport_production->antenne }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Cartes Emises</th>
                        <th>Cartes detrites</th>
                        <th>% de carte detruite</th>
                        <th style="width: 20px">Demandes en instances</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <tr>
                            <td>{{ $rapport_production->carte_detruite }}</td>
                            <td>{{ $rapport_production->carte_detruite }}</td>
                            <td>{{ $rapport_production->carte_emise }}</td>
                            <td>{{ $rapport_production->carte_en_instance }}</td>
                        </tr>
                      </tr>
                    </tbody>
                  </table>
                </div>
               
              </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Service Reception-expedition</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Nombre de lot recu</th>
                        <th>Nombre de demande</th>
                        <th>Demandes en instance</th>
                        <th style="width: 20px">Demandes transmise</th>
                        <th>Stock de testin</th>
                        <th>Stock de laminé imprimés</th>
                        <th>Stock de laminé vierges</th>
                        <th>Observations</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                        @if($rapport_reception_exception)
                        <tr>
                            <td>{{ $rapport_reception_exception->nbre_lot_introduit }}</td>
                            <td>{{ $rapport_reception_exception->nbre_demande_saisie }}</td>
                            <td>{{ $rapport_reception_exception->nbre_demande_en_instance }}</td>
                            <td>{{ $rapport_reception_exception->nbre_carte_transmise }}</td>
                            <td>{{ $rapport_reception_exception->stock_de_teslin }}</td>
                            <td>{{ $rapport_reception_exception->stock_de_tamine_imprime }}</td>
                            <td>{{ $rapport_reception_exception->stock_de_tamine_vierge }}</td>
                            <td>{{ $rapport_reception_exception->observation }}</td>

                        </tr>
                        @else
                        <tr>
                            <td>Pas de données pour ce jour</td>
                        </tr>
                     @endif
                    </tbody>
                  </table>
                </div>
               
              </div>
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Service Passeport</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Passeports refugiés</th>
                            <th>Paaseports emis</th>
                            <th>Paaseports fautés</th>
                            <th>Paaseports rejété</th>
                            <th>Paaseports vierge restant</th>
                            <th>Paaseports repris pour cau d'erreur</th>
                            <th>Observations</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            @if ($rapport_passeport)
                            <tr>
                          
                                <td>{{ $rapport_passeport->nbre_passport_refugie_produit }}</td>
                                <td>{{ $rapport_passeport->nbre_passport_ordi_produit }}</td>
                                <td>{{ $rapport_passeport->nbre_passport_ord_faute }}</td>
                                <td>{{ $rapport_passeport->nbre_passport_ordinaire_rejete }}</td>
                                <td>{{ $rapport_passeport->nbre_passport_ord_vierge_restant }}</td>
                                <td>{{ $rapport_passeport->nbre_passport_ord_faute }}</td>
                                <td>{{ $rapport_passeport->observation }}</td>

                       
                            </tr>
                            @else
                                <tr> <td>Pas de données</td></tr>
                               
                            @endif
                          </tr>
                        </tbody>
                      </table>
                    </div>
                   
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">VIP</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Nombre de carte disponibles</th>
                            <th>Nombre de carte restiuées</th>
                            <th>Nombre de carte recues</th>
                            <th>Observations</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            @if ($rapport_vip)
                            <tr>
                                <td>{{ $rapport_vip->nbre_de_carte_disponible }}</td>
                                <td>{{ $rapport_vip->nbre_de_carte_restitue }}</td>
                                <td>{{ $rapport_vip->nbre_de_carte_recus }}</td>
                                <td>{{ $rapport_vip->observation }}</td>
                            </tr>
                            @else
                                <tr> <td>Pas de données</td></tr>
                               
                            @endif
                          </tr>
                        </tbody>
                      </table>
                    </div>
                   
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">TRI</h3>
                    </div>
                    <div class="card-body p-0">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Nombre de lots introduits</th>
                            <th>Nombre de demandes saisies</th>
                            <th>Nombre de carte en instance</th>
                            <th>Observations</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            @if ($rapport_tri)
                            <tr>
                                <td>{{ $rapport_tri->nbre_lot_introduit }}</td>
                                <td>{{ $rapport_tri->nbre_demande_saisie }}</td>
                                <td>{{ $rapport_tri->nbre_demande_saisie }}</td>
                                <td>{{ $rapport_tri->observation }}</td>
                            </tr>
                            @else
                                <tr> <td>Pas de données</td></tr>
                               
                            @endif
                          </tr>
                        </tbody>
                      </table>
                    </div>
                   
                  </div>
                </div>
            </div>
        </div>
@endsection