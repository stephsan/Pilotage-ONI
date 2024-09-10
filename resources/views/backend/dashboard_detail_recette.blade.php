@extends('layouts.dashboard')
@section('dash_content')
<div class="card">                           
  <div class="card-header">
    <h3 class="card-title">Liste des taches en instances</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-card-widget="remove">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
  
  <!-- /.card-body -->
</div>
<div class="card">
      <div class="card-header">
        <h3 class="card-title">Recette par antenne</h3>
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
              <div class="col-md-10" id="bck_recette">
                
                <!-- ./chart-responsive -->
              </div>
              <!-- /.col -->
              
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          
          <!-- /.footer -->
        </div>
    
  @endsection
  @section('add_script')
  <script language = "javaScript">
    var url = "{{ route('recette.antenne') }}"
      $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 error:function(data){
                    if (xhr.status == 401) {
                       
                    }
                },
                 success: function (donnee) {
                        var cnib= [];
                        var dao= [];
                        var reversement= [];
                        var autre= [];
                        var donnch= new Array();
                        var antennes = new Array();
                    for(var i=0; i<donnee.length; i++)
                    {
                        cnib.push(parseInt(donnee[i].cnib));
                        dao.push(parseInt(donnee[i].dao));
                        reversement.push(parseInt(donnee[i].reversement));
                        autre.push(parseInt(donnee[i].autre));

                    }
                    donnch.push({
                                name: 'cnib',
                                data:cnib,
                                color:'green',
                                dataLabels: {
                                enabled: true,
                                }
                            })
                  donnch.push({
                                name: 'dao',
                                data:dao,
                                color:'blue',
                                dataLabels: {
                                enabled: true,
                                }
                            })
                donnch.push({
                                name: 'reversement',
                                data:reversement,
                                color:'yellow',
                                dataLabels: {
                                enabled: true,
                                }
                            })
                donnch.push({
                                name: 'autre',
                                data:autre,
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
                    Highcharts.chart('bck_recette', {
                        chart: {
                                    type: 'column'
                                },
                        xAxis: {
                                 categories: antennes
                            },
                        title: {
                            text: 'Recette par antenne'
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
