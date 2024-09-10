@extends('layouts.dashboard')
@section('dash_content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Situation des formulaires par antenne</h3>
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
    var url = "{{ route('formulaire.antenne') }}"
      $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 error:function(data){
                    if (xhr.status == 401) {
                       
                    }
                },
                 success: function (donnee) {
                        var formulaire_emis= [];
                        var formulaire_recu_prod= [];
                        var carte_sortie= [];
                       // var autre= [];
                        var donnch= new Array();
                        var antennes = new Array();
                    for(var i=0; i<donnee.length; i++)
                    {
                      formulaire_emis.push(parseInt(donnee[i].formulaire_emis));
                      formulaire_recu_prod.push(parseInt(donnee[i].formulaire_recu_prod));
                      carte_sortie.push(parseInt(donnee[i].carte_sortie));
                       // autre.push(parseInt(donnee[i].autre));

                    }
                    donnch.push({
                                name: 'Formulaires emis',
                                data:formulaire_emis,
                                color:'blue',
                                dataLabels: {
                                enabled: true,
                                }
                            })
                  donnch.push({
                                name: 'formulaires recu en production',
                                data:formulaire_recu_prod,
                                color:'orange',
                                dataLabels: {
                                enabled: true,
                                }
                            })
                donnch.push({
                                name: 'Formulaires sortie de la production',
                                data:carte_sortie,
                                color:'green',
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
                            text: 'Situation de traitement des formulaires'
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
