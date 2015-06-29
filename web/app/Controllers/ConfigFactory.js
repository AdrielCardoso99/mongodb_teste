angular.module('ConfigFactoryModule', ['ngRoute'])

        /* Configuracao de requisicao HTTP */
        .config(['$httpProvider', function ($httpProvider) {

                $httpProvider.defaults.useXDomain = true;
                delete $httpProvider.defaults.headers.common['X-Requested-With'];
                $httpProvider.defaults.headers.post = {'Content-Type': 'application/x-www-form-urlencoded'};
            }
        ])

        /* Componente de Resposta */
        .factory('ConfigFactory', function ($http, $location) {

            path = function () {
                return "http://localhost/mongodb/";
            }
             
        });