@extends('layouts.dashboard')
@section('dash_content')
<div class="col-md-12">
  <div class="card">
      <div class="card-header border-0">
        <h3 class="card-title"><center>Situation des teslins</center></h3>
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
            <th>Total Entrées </th>
            <th>Total Sorties</th>
            <th>Total Retours</th>
            <th>Stock Théorique</th>
          </tr>
          </thead>
          <tbody>
          <tr>
              <td>{{ $mouvement_teslins_entrees->sum('quantite')}}</td>
              <td>{{ $mouvement_teslins_sorties->sum('quantite')}}</td>
              <td>{{ $mouvement_teslins_retours->sum('quantite')}}</td>
              <td>{{ $stock_theorique}}</td>
              <td>
              </td>
          </tr>
          </tbody>
        </table>
      </div>
  </div>

</div>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Production par antenne</h3>
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
