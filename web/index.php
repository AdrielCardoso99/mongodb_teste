<html>
    <head>
        <title>Social Mongo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <!-- materialize FRAMEWORK -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type='text/css' href='app/componentes/materialize/css/materialize.min.css' rel='stylesheet' />
        <link type='text/css' href='app/componentes/materialize/css/style.css' rel='stylesheet' />
        <link type='text/css' href='app/componentes/prism.css' rel='stylesheet' />
        <link type='text/css' href='app/componentes/ghpages-materialize.css' rel='stylesheet' />

        <!-- COMPONETES FRAMEWORK -->
        <script type='text/javascript' src='app/componentes/angular-1.2.9/angular.min.js'></script>
        <script type='text/javascript' src='app/componentes/angular-1.2.9/angular-resource.min.js'></script>
        <script type='text/javascript' src='app/componentes/angular-1.2.9/angular-route.min.js'></script>
        <script type='text/javascript' src='app/componentes/angular-1.2.9/angular-loader.min.js'></script>
        <script type='text/javascript' src='app/componentes/angular-1.2.9/ng-error.js'></script>

        <!-- CONTROLLER -> CUSTOMIZADO -->
        <script type="text/javascript" src="app/Controllers/Rota.js"></script>
        <script type="text/javascript" src="app/Controllers/Controlador.js"></script>
        <script type="text/javascript" src="app/Controllers/ConfigFactory.js"></script>
        <script type="text/javascript" src="app/Controllers/LoginFactory.js"></script>

        <!-- jquery -->
        <script type="text/javascript" src="app/componentes/jquery/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="app/componentes/jquery/jquery-migrate-1.2.1.min.js"></script>

        <!--materialize-->
        <script type='text/javascript' src='app/componentes/materialize/js/init.js'></script>
        <script type='text/javascript' src='app/componentes/materialize/js/materialize.min.js'></script>
        <script type='text/javascript' src='app/componentes/live.js'></script>
        <script type='text/javascript' src='app/componentes/materialize.js'></script>

        <style>
            .hover:hover{
                opacity: 0.8;
                border: 1px solid #1E90FF;
                cursor: pointer;
            }
            body{
                background: #fff;
            }

            a:hover{
                text-decoration: none;
            }
            a{
                color:#696969;
            }
        </style>
    </head>

    <!-- ng-app definicao de MODULO defaut -->
    <body  ng-app='Rota'>

        <!-- definição de views -> tipo include -->
        <div ng-view></div>
    </body>
</html>
