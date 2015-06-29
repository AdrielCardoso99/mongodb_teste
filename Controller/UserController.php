<?php

Class UserController extends User {

    public static function init() {

        switch (@$_POST['action_args']) {
            case "new": self::actionNew();
                break;
            case "edit": self::actionEdit();
                break;
            case "remove": self::actionRemove();
                break;
            case "isUser": self::isUser();
                break;
            case "parseLogin": self::parseLogin();
                break;
            case "sair": self::parseSair();
                break;
        }
    }

    public static function actionNew() {

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        if (self::isEmail($email) == true) {

            $temp = DBController::init();
            $usuarios = $temp->db_user;

            $all = $usuarios->save(["email" => $email, "senha" => $senha, "nome" => $nome, "publicacao" => Array()]);

            if ($all['ok'] == true) {

                $obj = Array(
                    'nome' => $nome,
                    'email' => $email,
                    'senha' => $senha,
                    'status' => true,
                    'message' => 'registro feito com sucesso'
                );

                SessionController::set("user", $obj);
            } else {

                $obj = Array(
                    'nome' => $nome,
                    'email' => $email,
                    'senha' => $senha,
                    'status' => false,
                    'message' => "Erro ao registrar, tente novamente"
                );
            }
        } else {

            $obj = Array(
                'nome' => $nome,
                'email' => $email,
                'senha' => $senha,
                'status' => false,
                'message' => "Esse e-mail já está sendo usado por outro usuário"
            );
        }

        RotaController::res($obj);
    }

    public static function parseSair() {

        SessionController::destroy("user");

        $status = (empty(SessionController::get("user")) ? true : false);

        RotaController::res(Array(
            'status' => $status,
            'message' => ($status == "true" ? "você está saindo no Social Mongo" : "Algum erro acontenceu, tente sair novamente"),
        ));
    }

    public static function isUser() {

        $status = (empty(SessionController::get("user")) ? 'false' : 'true');

        RotaController::res(Array(
            'status' => $status,
            'message' => ($status == "true" ? "você está com a sua conta ativa no sistema" : "você deve fazer login para entrar"),
        ));
    }

    public static function isEmail($email) {

        $temp = DBController::init();
        $usuarios = $temp->db_user;

        return (iterator_to_array($usuarios->find(["email" => $email])) == Array() ? true : false);
    }

    public static function parseLogin() {

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $temp = DBController::init();
        $usuarios = $temp->db_user;

        $all = iterator_to_array($usuarios->find(["email" => $email, "senha" => $senha]));

        if ($all != Array()) {

            foreach ($all as $key => $value) {

                $obj = Array(
                    'token' => $key,
                    'nome' => $value['nome'],
                    'email' => $value['email'],
                    'senha' => $value['senha'],
                    'status' => true,
                    'message' => "Login feito com sucesso"
                );
            }

            SessionController::set("user", $obj);
        } else {

            $obj = Array(
                'email' => $email,
                'senha' => $senha,
                'status' => false,
                'message' => "Email ou senha incorretos",
                'status' => false,
            );
        }

        RotaController::res($obj);
    }

}
