var app = angular.module('Rota', ['ngRoute', 'ngResource', 'Controlador']);

app.config(function($routeProvider, $locationProvider) {
    
    $routeProvider.
            when('/home', {
                templateUrl: 'app/view/home.html',
                controller: 'HomeController'
            }).
            when('/login', {
                templateUrl: 'app/view/login.html',
                controller: 'LoginController'
            }).
            when('/cadastro', {
                templateUrl: 'app/view/cadastro.html',
                controller: 'CadastroController'
            })
            .otherwise({redirectTo : '/home'});
});