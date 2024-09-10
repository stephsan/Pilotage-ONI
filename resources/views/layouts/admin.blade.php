<html>
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicons -->
    <link href="{{asset('frontend/img/logo-ecotec.jpg')}}" rel="icon">

    <link rel="stylesheet" href="{{asset('/css/login/bootstrap.min.css')}}" crossorigin="anonymous">
    <script src="{{asset('/theme/vendor/bootstrap/js/bootstrap.min.js')}}" crossorigin="anonymous" defer></script>
    <!-- importer le fichier de style -->

    <link rel="stylesheet" href="{{asset('css/login/style.css')}}">
    <title>Outils de Pilotage de l'ONI</title>
 </head>
 <body>
     <div class="container-fluid">
        @yield('page-content')
    </div>
 </body>
</html>
