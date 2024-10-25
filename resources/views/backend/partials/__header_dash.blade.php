<section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $tache_encours->count() }}</h3>

              <p>Taches en cours</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('dashboard')}}?detail=tache"  class="small-box-footer">Details <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $nombre_de_formulaire_emis->sum('nombre') }}<sup style="font-size: 20px"></sup></h3>
              <p>Formulaires Emises</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('dashboard')}}?detail=formulaire_emise"  class="small-box-footer">Details <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
    @if(return_role_adequat(env('ID_MANAGER_PRODUCTION')))
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ format_prix($statistique_cnib_du_mois_en_cours->sum('nbre_carte_imprime')) }}</h3>
              <p>Carte imprimées au cours de ce mois</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('dashboard')}}?detail=statistique_du_mois" class="small-box-footer">Details <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
    @elseif (return_role_adequat(env('ID_MANAGER_GENERAL_ROLE')))
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ format_prix($recette_de_lannee_encours->sum('montant')) }}</h3>
                <p>De recette pour cette annee</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{ route('dashboard')}}?detail=recette" class="small-box-footer">Details <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
    @endif
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $stock_theorique }}</h3>
              <p>Stock de Teslin</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('dashboard')}}?detail=testlin" class="small-box-footer">Details <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>