
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->

<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('adminlte/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('adminlte/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('adminlte/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('adminlte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('adminlte/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('adminlte/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('adminlte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('adminlte/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/plugins.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('adminlte/dist/js/adminlte.js')}}"></script>
<script src="{{asset('js/autre/highcharts.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('adminlte/dist/js/pages/dashboard.js')}}"></script>

<!-- jQuery Mapael -->
<script src="{{asset('adminlte/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('adminlte/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>

<!-- For Datatables -->
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src=
"https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" 
        integrity=
"sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" 
        crossorigin="anonymous">
    </script>
    <script src=
"https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" 
        integrity=
"sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" 
        crossorigin="anonymous">
    </script>


{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<!-- Inclure Bootstrap Datepicker JS et CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<!-- Inclure la traduction française -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.fr.min.js"></script>
    <!-- Inclure Bootstrap CSS -->
{{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"> --}}

<!-- Inclure jQuery -->



<script type="text/javascript">
  $('.flash-message').delay(3000).slideUp(350);
  </script>
<script>
  $(function() {
    $("body").delegate(".datepicker", "focusin", function(){
        $(this).datepicker();
    });
});
</script>
<script>
  jQuery(function($){
	$.datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: '&#x3c;Préc',
		nextText: 'Suiv&#x3e;',
		currentText: 'Aujourd\'hui',
		monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
		'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
		monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
		'Jul','Aou','Sep','Oct','Nov','Dec'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
		dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
		weekHeader: 'Sm',
		dateFormat: 'dd-mm-yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: '',
		minDate: 0,
		maxDate: '+12M +0D',
		numberOfMonths: 2,
		showButtonPanel: true
		};
	$.datepicker.setDefaults($.datepicker.regional['fr']);
});
</script>
<!-- For Datatable -->
<script>
        $(document).ready(function(){
         
        $('.date_affecte').datepicker({
            changeMonth: true,
            changeYear: true,
            monthNames: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            dayNamesMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
            endDate: new Date(),
            format: 'dd-mm-yyyy',
            language: 'fr',
            autoclose: true
        }).val();
        });
        $(document).ready(function(){
        $('.date_tache').datepicker({
            changeMonth: true,
            changeYear: true,
            startDate: new Date(),
            format: 'dd-mm-yyyy',
            monthNames: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            dayNamesMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
          
        });
        });
</script>
<script>
  $(document).ready(function(){
    form.reset();
  })
</script>
<script>

function verifierSaisiequittance(ccd, nombre_formulaire, type_operation, idModification){
           var nbre_formulaire= $('#'+nombre_formulaire).val()
           var element_modified= $('#'+idModification).val()

           var ccd= $('#'+ccd).val()
            var url = "{{ route('quittance.verifier_saisie') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {nbre_formulaire: nbre_formulaire, ccd: ccd, type_operation: type_operation, element_modified:element_modified} ,
                    error:function(){alert('error');},
                    success:function(data){
                        if(data < 0){
                          $('#'+nombre_formulaire).val('')
                            $('.message_verification_saisie_nombre').show()
                        }
                        else{
                            $('.message_verification_saisie_nombre').hide()
                        }
                        
                    }
                });
}
       function getCitds(parent, child)
        {
          //alert(parent);
            var antenne = $("#"+parent).val();
            //alert(antenne);
            var url = '{{ route('ctids.selection') }}';
            $.ajax({
                    url: url,
                    type: 'GET',
                    data: {antenne: antenne},
                    dataType: 'json',
                    error:function(data){alert("Erreur");},
                    success: function (data) {
                      console.log(data);
                        var options = '<option></option>';
                        for (var x = 1; x < data.length; x++) {
                            options += '<option value="' + data[x]['id'] + '">' + data[x]['nom_ctid'] + '</option>';
                        }
                       $('#'+child).html(options);
                    }
            });
        }
        function getantenneByRegion(region, antenne)
        {
            var region = $("#"+region).val();
            var url = '{{ route('antenne.selection') }}';
            $.ajax({
                    url: url,
                    type: 'GET',
                    data: {region: region},
                    dataType: 'json',
                    error:function(data){alert("Erreur");},
                    success: function (data) {
                      console.log(data);
                        var options = '<option></option>';
                        for (var x = 1; x < data.length; x++) {
                            options += '<option value="' + data[x]['id'] + '">' + data[x]['libelle'] + '</option>';
                        }
                       $('#'+antenne).html(options);
                    }
            });
        }
        function getCommuneOuCcdByCtid(ctid, commune, communeOuCtid)
        {
            var ctid = $("#"+ctid).val();
            var url = '{{ route('communes.selection') }}';
            $.ajax({
                    url: url,
                    type: 'GET',
                    data: {ctid: ctid, communeOuCtid:communeOuCtid},
                    dataType: 'json',
                    error:function(data){alert("Erreur");},
                    success: function (data) {
                      console.log(data);
                        var options = '<option></option>';
                        for (var x = 1; x < data.length; x++) {
                            options += '<option value="' + data[x]['id'] + '">' + data[x]['libelle'] + '</option>';
                        }
                       $('#'+commune).html(options);
                    }
            });
        }
</script>
<script>

   $('.select2').select2()
   function changeValue(parent, child, niveau)
        {
            var idparent_val = $("#"+parent).val();
            var id_param = parseInt(niveau);
            //alert(niveau);
            var url = '{{ route('valeur.selection') }}';
            $.ajax({
                    url: url,
                    type: 'GET',
                    data: {idparent_val: idparent_val, id_param:id_param, parent:parent},
                    dataType: 'json',
                    error:function(data){alert("Erreur");},
                    success: function (data) {
                        var options = '<option></option>';
                        for (var x = 0; x < data.length; x++) {
                            options += '<option value="' + data[x]['id'] + '">' + data[x]['name'] + '</option>';
                        }
                       $('#'+child).html(options);
                    }
            });
        }

       
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>