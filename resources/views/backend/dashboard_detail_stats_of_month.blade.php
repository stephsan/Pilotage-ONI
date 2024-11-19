@extends('layouts.dashboard')
@section('dash_content')
<div class="card">                           
  <div class="card-header">
    <h3 class="card-title">Production du mois en cours</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-card-widget="remove">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
      <tr style="background-color:#0b9e44; color:white">
        <th>N°</th>
        <th>Antenne</th>
        <th>Carte imprimée</th>
        <th>Nombre de lots introduits</th>
        <th>Demandes saisies</th>
        <th>Cartes endomagées</th>
        <th>Cartes en instance</th>
        <th>Cartes transmises</th>
      </tr>
      </thead>
      <tbody>
        @php
        $i=0;
      @endphp
      @foreach ($prod_du_mois_par_antenne as $prod_du_mois_par_ant)
            @php
            $i++;
          @endphp
        <tr>
          <td>{{$i}}</td>
          <td>{{ $prod_du_mois_par_ant->antenne }}</td>
          <td>{{ $prod_du_mois_par_ant->carte_imprime }}</td>
          <td>{{ $prod_du_mois_par_ant->lot_introduit }}</td>
          <td>{{ $prod_du_mois_par_ant->demande_saisie }}</td> 
          <td>{{ $prod_du_mois_par_ant->carte_endomage }}</td>  
          <td>{{ $prod_du_mois_par_ant->demande_en_instance }}</td>                  
          <td>{{ $prod_du_mois_par_ant->carte_transmise }}</td>                  
          {{-- <td><a href="#" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a></td> --}}
        </tr>
      @endforeach
      </tbody>
      <tfoot>
      <tr>
        <th>N°</th>
        <th>Antenne</th>
        <th>Carte imprimée</th>
        <th>Nombre de lots introduits</th>
        <th>Demandes saisies</th>
        <th>Cartes endomagées</th>
        <th>Cartes en instance</th>
        <th>Cartes transmises</th>
        {{-- <th>Action</th>  --}}
      </tr>
      </tfoot>
    </table>
  </div>
  <!-- /.card-body -->
</div>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Production de l'année en cours par antenne</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-card-widget="remove">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-md-10" id="bck_prod">
            
            <!-- ./chart-responsive -->
          </div>
          
        </div>
      </div>
</div>

    
  @endsection
  @section('add_script')
  <script language = "javaScript">
    var url = "{{ route('production.antenne') }}"
      $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 error:function(data){
                    if (xhr.status == 401) {
                       
                    }
                },
                 success: function (donnee) {
                        var carte_imprime= [];
                        var carte_endomage= [];
                        var demande_saisie= [];
                        var autre= [];
                        var donnch= new Array();
                        var antennes = new Array();
                    for(var i=0; i<donnee.length; i++)
                    {
                      carte_imprime.push(parseInt(donnee[i].carte_imprime));
                      carte_endomage.push(parseInt(donnee[i].carte_endomage));
                      demande_saisie.push(parseInt(donnee[i].demande_saisie));
                       // autre.push(parseInt(donnee[i].autre));

                    }
                    donnch.push({
                                name: 'Demandes saisies',
                                data:demande_saisie,
                                color:'blue',
                                dataLabels: {
                                enabled: true,
                                }
                            })
                  donnch.push({
                                name: 'Cartes imprimés',
                                data:carte_imprime,
                                color:'green',
                                dataLabels: {
                                enabled: true,
                                }
                            })
                donnch.push({
                                name: 'carte endomage',
                                data:carte_endomage,
                                color:'red',
                                dataLabels: {
                                enabled: true,
                                }
                            })
                    console.log(donnch);
                    for(var i=0; i<donnee.length; i++)
                            {
                              antennes[i] = donnee[i].antenne
                            }
                    console.log(antennes)
                    Highcharts.chart('bck_prod', {
                        chart: {
                                    type: 'column'
                                },
                        xAxis: {
                                 categories: antennes
                            },
                        title: {
                            text: 'Situation de la production CNIB par entité'
                        },
                        credits : {
                            enabled: false
                        },
                       
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                    showInLegend: true
                            }
                        },
                        series:donnch
                    });

}

});      
</script>
@endsection
