/* global $location, angular, Materialize */

angular.module('Controlador', ['ngRoute', 'ngError', 'LoginFactoryModule'])

        .config(['$httpProvider', function ($httpProvider) {

                $httpProvider.defaults.useXDomain = true;
                delete $httpProvider.defaults.headers.common['X-Requested-With'];
                $httpProvider.defaults.headers.post = {'Content-Type': 'application/x-www-form-urlencoded'};
            }
        ])

        .controller('LoginController', function ($scope, LoginFactory, $http, $location) {

            $scope.load = true;

            $scope.entrar = function () {

                $scope.load = false;

                var email = $('#entrar_email').val();
                var senha = $('#entrar_senha').val();

                $http({
                    method: "post",
                    url: "http://localhost/mongodb/",
                    data: "action=user&action_args=parseLogin&email=" + email + "&senha=" + senha,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                        .success(function (data) {

                            if (data['status'] === true) {

                                Materialize.toast(data['message'], 4000);

                                $scope.load = false;
                                $location.url("home");
                            } else {

                                Materialize.toast(data['message'], 4000);
                            }

                            $scope.load = false;

                        })
                        .error(function (e) {

                            Materialize.toast("Erro com a conexão com o servidor, tente novamente mais tarde", 4000);

                            $scope.load = false;
                        });
            };

            $scope.cadastrar = function () {

                $scope.load = false;

                var nome = $('#cadastrar_nome').val();
                var email = $('#cadastrar_email').val();
                var senha = $('#cadastrar_senha').val();

                $http({
                    method: "post",
                    url: "http://localhost/mongodb/",
                    data: "action=user&action_args=new&email=" + email + "&senha=" + senha + "&nome=" + nome,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                        .success(function (data) {

                            if (data['status'] === true) {

                                Materialize.toast(data['message'], 4000);

                                $scope.load = true;
                                $location.url("home");
                            } else {

                                $scope.load = true;
                                Materialize.toast(data['message'], 4000);
                            }

                        })
                        .error(function (e) {

                            Materialize.toast("Erro com a conexão com o servidor, tente novamente mais tarde", 4000);

                            $scope.load = true;
                        });
            };
        })

        .controller('HomeController', function ($scope, LoginFactory, $http, $location) {

            var status = false;

            // verificando se existe credencial
            LoginFactory.isLogin();

            // get publicacoes
            initPublicacoes();

            $scope.load = true;
            $scope.cardempty = false;


            $scope.acao_naoCurtir = function (token) {

                alert(token);

            };

            $scope.acao_curtir = function (token) {

                $http({
                    method: "post",
                    url: "http://localhost/mongodb/",
                    data: "action=publicar&action_args=curtir&token=" + token,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                        .success(function (data) {

                            initPublicacoes();

                            Materialize.toast(data['message'], 4000);

                        })
                        .error(function (e) {
                            Materialize.toast("Erro com a conexão com o servidor, tente novamente mais tarde", 4000);
                        });
            };
            
            $scope.acao_comentar = function (token) {

                alert(token);
            };
            
            $scope.acao_excluir = function (token) {

                alert(token);
            };

            $scope.acao_publicar = function () {

                $('#acao_publicacao_conteudo').html(elem());

                var publicacao = $('#textarea1').val();
                $('#textarea1').val("");

                $http({
                    method: "post",
                    url: "http://localhost/mongodb/",
                    data: "action=publicar&action_args=new&publicacao=" + publicacao,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                        .success(function (data) {

                            initPublicacoes();

                            Materialize.toast(data['message'], 4000);

                        })
                        .error(function (e) {
                            Materialize.toast("Erro com a conexão com o servidor, tente novamente mais tarde", 4000);
                        });
            };

            $scope.acao_cancelar_modal = function () {

                $('#modal1').closeModal();
                $('#acao_publicacao_conteudo').html(elem());

                Materialize.toast('Publicação cancelada', 4000); // 4000 is the duration of the toast
            };

            $scope.acao_sair = function () {

                $scope.load = false;

                $http({
                    method: "post",
                    url: "http://localhost/mongodb/",
                    data: "action=user&action_args=sair",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                        .success(function (data) {

                            if (data.status === true) {

                                Materialize.toast(data['message'], 4000);

                                $location.url("login");
                            } else {
                                Materialize.toast(data['message'], 4000);
                            }

                        })
                        .error(function (e) {
                            Materialize.toast("Erro com a conexão com o servidor, tente novamente mais tarde", 4000);
                        });
            };

            var refresh = setInterval(function () {

                initPublicacoes();
            }, 1000);

            function initPublicacoes() {

                $http({
                    method: "post",
                    url: "http://localhost/mongodb/",
                    data: "action=publicar&action_args=publicacoes",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                        .success(function (data) {

                            if (data.length !== 0) {

                                status = true;
                                $scope.load = true;

                                $scope.publicacoes = data;
                                $scope.cardempty = true;

                                clearInterval(refresh);
                            } else {

                                $scope.cardempty = false;
                            }

                        })
                        .error(function (e) {
                            Materialize.toast("Você está sem conexão com o servidor tente atualizar a página", 4000);

                            $scope.load = true;
                        });
            }

            function elem() {

                $scope.load_post = true;

                return ' <div class="input-field col s12" style="padding: 2%;">' +
                        '<textarea id="textarea1" class="materialize-textarea"></textarea>' +
                        '<label for="textarea1">No que você está pensando?</label>' +
                        '</div>';
            }
            ;
        });
