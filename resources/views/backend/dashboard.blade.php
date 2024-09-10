@extends('layouts.dashboard')
@section('dash_content')

    <div class="card">
      <div class="card-header border-0">
        <h3 class="card-title"> Statistique Production suivant le registre journalier </center></h3>
       
        <div class="card-tools">
          <a href="#" class="btn btn-tool btn-sm">
            <i class="fas fa-download"></i>
          </a>
          <a href="#" class="btn btn-tool btn-sm">
            <i class="fas fa-bars"></i>
          </a>
        </div>
      </div>
      <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-7">
                  <p style="margin-left: 10px;">CNIB Imprimées :</p>
              </div>
              <div class="col-md-5">
                  {{ $nombre_de_carte_produits->sum('nbre_carte_imprime') }}
              </div>
           </div>
           <div class="row">
      
            <div class="col-md-7">
                <p style="margin-left: 10px;">Nombre de cartes Endomagées :</p>
            </div>
            <div class="col-md-5">
                {{ $nombre_de_carte_produits->sum('nbre_carte_endomage') }}
            </div>
         </div>
         <div class="row">
          <div class="col-md-7">
              <p style="margin-left: 10px;">Nombre de demande en instance :</p>
          </div>
          <div class="col-md-5">
              {{ $nombre_de_carte_produits->sum('nbre_demande_en_instance') }}
          </div>
       </div>
       <div class="row">
        <div class="col-md-7">
            <p style="margin-left: 10px;">Nombre de carte transmises :</p>
        </div>
        <div class="col-md-5">
            {{ $nombre_de_carte_produits->sum('nbre_carte_transmise') }}
        </div>
     </div>
        </div>
         <div class="col-md-6">
          <div class="row">
            <div class="col-md-7">
                <p style="margin-left: 10px;">Passeport ord. produits :</p>
            </div>
            <div class="col-md-5">
                {{ $nombre_de_passport_produits->sum('nbre_passport_ordi_produit') }}
            </div>
         </div>
         <div class="row">
          <div class="col-md-7">
              <p style="margin-left: 10px;">Passeport ord. réjétés :</p>
          </div>
          <div class="col-md-5">
              {{ $nombre_de_passport_produits->sum('nbre_passport_ordinaire_rejete') }}
          </div>
       </div>
       <div class="row">
          <div class="col-md-7">
              <p style="margin-left: 10px;">Passeport ord. vierge restant :</p>
          </div>
          <div class="col-md-5">
              {{ $nombre_de_passport_produits->sum('nbre_passport_ord_vierge_restant') }}
          </div>
       </div> 
       <div class="row">
        <div class="col-md-7">
            <p style="margin-left: 10px;">Passeport refugié produits :</p>
        </div>
        <div class="col-md-5">
            {{ $nombre_de_passport_produits->sum('nbre_passport_refugie_produit') }}
        </div>
     </div>
         </div>
      </div>
      
    </div>


<div class="row">
  
  <div class="col-md-12">
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
            <th>Responsable</th>
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
              <td>{{ $tache_encour->porteur->name }} {{ $tache_encour->porteur->prenom }} - {{ $tache_encour->porteur->fonction }}</td>                  
              <td>
                <button  data-toggle="modal" onclick="view_task({{ $tache_encour->id }});"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default" data-target="#view-task" ><i class="fa fa-seach"></i></a>
                <a href="#" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a></td>
              
            </tr>
          @endforeach
          </tbody>
          <tfoot>
          <tr>
            <th>N°</th>
            <th>Titre</th>
            <th>Date d'affectation</th>
            <th>Date limite</th>
            <th>Responsable</th>
            <th>Action</th>
          </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    </div>
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
              <div class="col-md-10" id="bck1">
                
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
  @section('modal_section')
  <div class="modal fade" id="view-task">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Details sur la tache</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <p>Titre de la tache :</p>
                    </div>
                    <div class="col-md-8">
                      <p id="titre"></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                      <p>Description de la tache :</p>
                  </div>
                  <div class="col-md-8">
                    <p id="description"></p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                    <p>Porteur :</p>
                </div>
                <div class="col-md-8">
                  <p id="porteur"></p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                  <p>Statut :</p>
              </div>
              <div class="col-md-8">
                <p id="statut"></p>
            </div>
          </div>
            <div class="row">
              <div class="col-md-4">
                  <p>Tache affectée le :</p>
              </div>
              <div class="col-md-8">
                <p id="date_daffectation"></p>
            </div>
          </div>
            <div class="row">
              <div class="col-md-4">
                  <p>Date limite de traitement :</p>
              </div>
              <div class="col-md-8" style='color:red'>
                <p id="date_limite_de_traitement"></p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
        </div>
        </div>
      </div>
    </div>
  </div>
  @endsection
  @section('add_script')
  <script>
    function view_task(id){
                var id=id;
                //alert(id)
                $("#titre").val(id);
                $("#porteur").val('');
                $("#description").val('');
                $("#statut").val('');
                $("#date_daffectation").val('');
            var url = "{{ route('tache.viewById') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        console.log(data)
                        $('#titre').text(data.titre);
                        $('#description').text(data.description);
                        $('#porteur').text(data.porteur);
                        $('#date_limite_de_traitement').text(data.deadline);
                        $('#date_daffectation').text(data.date_daffectation);
                        $('#statut').text(data.statut);
                        
                    }
                });
        }
  </script>
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
