<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Outils de pilotage de l'ONI </title>

  <!-- Google Font: Source Sans Pro -->

 {{-- <link href="{{asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet"> --}}
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/css/main.css')}}"> 
  {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}
  <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminlte/plugins/select2/css/select2.min.css')}}">

  <link rel="stylesheet" href="{{asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminlte/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/toastr/toastr.min.css')}}>
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/summernote/summernote-bs4.min.css')}}">
  <link rel="stylesheet" href="{{asset('/css/plugins.css')}}">
  <!-- For Backend -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  {{-- <link rel="stylesheet" href="{{asset('/css/plugins.css')}}"> --}}
   
  <link rel="stylesheet" href="{{asset('/css/datepicker.css')}}"> 
  <link href="{{asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    {{-- <link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"> --}}

  <!-- End Backend -->
</head>
<body  class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  {{-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div> --}}


  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Accueil</a>
      </li>
      
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
     
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
          {{-- <span class="badge badge-warning navbar-badge">15</span> --}}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          
          
            <a href="{{ route('logout') }}" class="dropdown-item"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();"><i class="fa fa-ban fa-fw pull-right"></i>
            Se Deconnecter
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
          
          <div class="dropdown-divider"></div>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <a href="{{route('dashboard')}}"  style="width: 250px;">
      <center>Pilotage - ONI</center> 
      {{-- <img src="{{asset('/adminlte/logo-oni.png')}}" width="250" height="200" alt="ONI Logo" class="brand-image"> --}}
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}} {{Auth::user()->Prenom}}</a>
        </div>
      </div>
     
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @can('acceder_au_dashboard', Auth::user()) 
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link @yield("dashboard")">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Tableau De Bord</p>
            </a>            
          </li>
        @endcan
          
          @can('formulaire.recap', Auth::user()) 
          <li class="nav-item @yield("formulaire")">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>Formulaire
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('formulaire.create', Auth::user()) 
              <li class="nav-item">
              <a href="{{ route('formulaire_prod.index') }}" class="nav-link @yield("affectation")">
                      <i class="nav-icon fa fa-list-alt" aria-hidden="true"></i>
                      <p>Affectation</p>
                    </a>
              </li>
            @endcan
            @can('formulaire.receptionner', Auth::user()) 
              <li class="nav-item @yield('administration-role')">
              <a href="{{ route('formulaire_recu.liste') }}" class="nav-link @yield("reception-lot")">
                      <i class="nav-icon fa fa-check-square"></i>
                      <p>Reception des lots</p>
                    </a>
              </li>
            @endcan
          @can('formulaire.recap', Auth::user()) 
          <li class="nav-item @yield('administration-role')">
            <a href="{{ route('formulaire.etat') }}" class="nav-link @yield("recap")">
                    <i class="nav-icon fa fa-check-square"></i>
                    <p>Recap formulaires</p>
                  </a>
            </li>
            @endcan
              
                                         
            </ul>            
          </li> 
        @endcan
        @can('gerer_teslin', Auth::user())
        <li class="nav-item @yield("testlin")">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>Teslin
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="{{ route('testlin.index') }}" class="nav-link @yield("mouvement")">
                    <i class="nav-icon fa fa-list-alt" aria-hidden="true"></i>
                    <p>Mouvements stock</p>
                  </a>
            </li>                            
          </ul>            
        </li> 
        @endcan
        
        @can('quittance.lister', Auth::user())                   
          <li class="nav-item @yield("recette")">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>Recette
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('quittance.lister', Auth::user())  
              <li class="nav-item">
                <a href="{{ route('recette_quittance.index') }}" class="nav-link @yield("saisie")">
                        <i class="nav-icon fa fa-list-alt" aria-hidden="true"></i>
                        <p>Quittances recettes</p>
                      </a>
                </li>
            @endcan
           @can('recette.view', Auth::user()) 
              <li class="nav-item">
              <a href="{{ route('recette.index') }}" class="nav-link @yield("recette-saisie")">
                      <i class="nav-icon fa fa-list-alt" aria-hidden="true"></i>
                      <p>Saisie recette</p>
                    </a>
              </li>
           @endcan
           @can('recette.synthese', Auth::user())  
           <li class="nav-item">
              <a href="{{ route('recette.synthese') }}" class="nav-link @yield("recette-synthese")">
                      <i class="nav-icon fa fa-check-square"></i>
                      <p>Synthese recette</p>
                    </a>
              </li>
          @endcan
              {{-- <li class="nav-item @yield('administration-role')">
                <a href="{{ route('formulaire.etat') }}" class="nav-link @yield("recap")">
                        <i class="nav-icon fa fa-check-square"></i>
                        <p>Recap formulaires</p>
                      </a>
                </li> --}}
                                         
            </ul>            
          </li> 
          @endcan 
          <li class="nav-item @yield("tache")">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>Suivi des taches
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{ route('tache.index') }}" class="nav-link @yield("tache_encours")">
                      <i class="nav-icon fa fa-list-alt" aria-hidden="true"></i>
                      <p>Taches en cours</p>
                    </a>
              </li>                       
            </ul> 
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{ route('registre.rapport_journalier') }}" class="nav-link @yield("registre")">
                      <i class="nav-icon fa fa-list-alt" aria-hidden="true"></i>
                      <p>Taches finalisées</p>
                    </a>
              </li>
                                         
            </ul> 
                    
          </li> 
    @can('acceder_a_la_synthese',Auth::user())
          <li class="nav-item @yield("statistique")">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>Statistique
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
      @can('acceder_au_registre',Auth::user())
              <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="{{ route('registre.index') }}" class="nav-link @yield("registre")">
                        <i class="nav-icon fa fa-list-alt" aria-hidden="true"></i>
                        <p>Registre Journalier</p>
                      </a>
                </li>                       
              </ul> 
      @endcan
          @can('acceder_a_la_synthese',Auth::user())
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{ route('registre.rapport_journalier') }}" class="nav-link @yield("rapport")">
                      <i class="nav-icon fa fa-list-alt" aria-hidden="true"></i>
                      <p>Rapport journalier</p>
                    </a>
              </li>
                                         
            </ul> 
           @endcan
                    
          </li>
      @endcan      
          @can('gerer_user', Auth::user()) 
            <li class="nav-item @yield("administration")" >
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Administration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
          @can('gerer_entite', Auth::user()) 
              <li class="nav-item">
                <a href="{{ route("centreCollecte.index") }}" class="nav-link @yield("administration-centreCollecte")">
                  <i class="fa fa-cogs nav-icon"></i>
                  <p>Centre de collecte</p>
                </a>
              </li>
         
              <li class="nav-item">
                <a href="{{ route("centreTraitement.index") }}" class="nav-link @yield("administration-centreTraitement")">
                  <i class="fa fa-cogs nav-icon"></i>
                  <p>Centre de Traitement</p>
                </a>
              </li>
              <li class="nav-item @yield('administration-role')">
                <a href="{{ route("antenne.index") }}" class="nav-link @yield("administration-antenne")">
                  <i class="fa fa-cogs nav-icon"></i>
                  <p>Antennes</p>
                </a>
              </li>
              <li class="nav-item @yield('administration-entite')">
                <a href="{{ route("entite.index") }}" class="nav-link @yield("administration-entite")">
                  <i class="fa fa-cogs nav-icon"></i>
                  <p>Entite</p>
                </a>
              </li>
           @endcan
           @can('gerer_user', Auth::user()) 
              <li class="nav-item">
                <a href="{{ route("user.index") }}" class="nav-link @yield("user")">
                  <i class="fa fa-users nav-icon"></i>
                  <p>Utilisateurs</p>
                </a>
              </li>
              <li class="nav-item @yield('administration-role')">
                <a href="{{ route("role.index") }}" class="nav-link @yield("administration-role")">
                  <i class="fa fa-cogs nav-icon"></i>
                  <p>Rôles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route("permissions.index") }}" class="nav-link @yield("administration-permission")">
                  <i class="fa fa-cogs nav-icon"></i>
                  <p>Permissions</p>
                </a>
              </li>
          @endcan
          @can('gerer_parametre', Auth::user()) 
              <li class="nav-item">
                <a href="{{route('parametre.index')}}" class="nav-link @yield("administration-parametre")">
                  <i class="fa fa-cogs nav-icon"></i>
                  <p>Paramètres</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('valeur.index')}}" class="nav-link @yield("administration-valeur")">
                  <i class="fa fa-cogs nav-icon"></i>
                  <p>Valeurs</p>
                </a>
              </li>
        @endcan                           
            </ul>
            {{-- <li class="nav-item @yield("greffier")">
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  Greffiers
                  <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link @yield("greffier-liste")">
                      <i class="fa fa-users nav-icon"></i>
                      <p>Liste des Greffiers</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link @yield("greffier-create")">
                      <i class="fa fa-user-plus nav-icon"></i>
                      <p>Ajouter Greffier</p>
                    </a>
                  </li>
                </ul>
              </li> --}}
          </li>          
        
          @endcan
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>