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
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr style="background-color:#0b9e44; color:white">
            <th>N°</th>
            <th>Titre</th>
            <th>Date d'affectation</th>
            <th>Date limite</th>
            <th>Action</th> 
          </tr>
          </thead>
          <tbody>
          @foreach ($tache_encours as $tache_encour)
            <tr 
              @if (tache_en_retard($tache_encour->id) == true)
                style='color:red'
              @endif
            >
              <td>1</td>
              <td>{{ $tache_encour->intitule }}</td>
              <td>{{ format_date($tache_encour->date_daffectation) }}</td>
              <td>{{ format_date($tache_encour->deadline) }}</td> 
                            
              <td><a href="#" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a></td>
            </tr>
          @endforeach
          </tbody>
          <tfoot>
          <tr>
            <th>N°</th>
            <th>Titre</th>
            <th>Date d'affectation</th>
            <th>Date limite</th>
            <th>Action</th>
          </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
</div>
    
            <!-- /.card -->
    
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
                    Highcharts.chart('bck1', {
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
