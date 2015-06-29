<?php

Class PublicacaoController {

    public static function init() {

        switch (@$_POST['action_args']) {
            case "new": self::actionNew();
                break;
            case "publicacoes": self::getPublicacoes();
                break;
            case "curtir": self::setCurtir();
                break;
        }
    }

    public static function setCurtir() {

        $temp = DBController::init();
        $publicacao = $temp->db_publicacao;

        $cursor2 = $publicacao->insert(array('_id' => array('$in' => $_POST['token'])));

        RotaController::res($obj);
    }

    public static function getPublicacoes() {

        $res = Array();
        $temp = DBController::init();
        $publicacao = $temp->db_user;

//        $publicacao->remove();

        $user = SessionController::get("user");

        $obj = iterator_to_array($publicacao->find());

        print_r($obj);

        die();

        foreach ($obj as $key => $value) {

            $value['proprietario'] = ($key == $user['token'] ? true : false);
            $value['token'] = $key;

            $res[] = $value;
        }

        RotaController::res($res);
    }

    public static function actionNew() {

        if (empty(SessionController::get("user")) == false && empty($_POST['publicacao']) == false) {

            $user = SessionController::get("user");

            $temp = DBController::init();
            $publicar = $temp->db_user;

            $nova_publicacao = Array("post" => $_POST['publicacao'], "data" => date("H") . "h" . date("i") . ' ' . date("d/m/Y"));

            $all = $publicar->update(array('_id' => new MongoId($user['token'])), array('$set' => array("publicacao" => $nova_publicacao)), array("multiple" => true));

            if ($all['ok'] == true) {

                $obj = Array(
                    'status' => true,
                    'message' => 'registro feito com sucesso'
                );

                SessionController::set("user", $obj);
            } else {

                $obj = Array(
                    'status' => false,
                    'message' => "Erro ao registrar, tente novamente"
                );
            }
        } else {

            $obj = Array(
                'status' => false,
                'message' => "Sua publicação está vazia, tente escrever algo"
            );
        }

        RotaController::res($obj);
    }

}
