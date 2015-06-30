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
            case "naocurtir": self::setNaoCurtir();
                break;
            case "remover": self::removerAction();
                break;
            case "comentario": self::comentarioAction();
                break;
        }
    }

    public function removerAction() {

        if (self::isMyPublicacao($_POST['token']) == true) {

            $obj = Array(
                'status' => true,
                'message' => 'registro removido com sucesso'
            );
        } else {

            $obj = Array(
                'status' => false,
                'message' => 'impossível remover o registro, tente novamente mais tarde'
            );
        }

        RotaController::res($obj);
    }

    public static function comentarioAction() {

        $temp = DBController::init();
        $publicacao = $temp->db_publicacao;

        if (empty($_POST['token']) == false && empty($_POST['comentario']) == false) {
            foreach (iterator_to_array($publicacao->find(['_id' => new MongoId($_POST['token'])])) as $value) {

                $value['comentarios'][count($value['comentarios'])] = $_POST['comentario'];
                
                $cursor2 = $publicacao->update(
                        Array(
                    '_id' => new MongoId($_POST['token'])), Array(
                    "naoCurtir" => $value['naoCurtir'],
                    "curtir" => $value['curtir'],
                    "comentarios" => $value['comentarios'],
                    "user_token" => $value['user_token'],
                    "post" => $value['post'],
                    "data" => $value["data"]));

                if ($cursor2['ok'] != true) {

                    $obj = Array(
                        'status' => false,
                        'message' => "Erro ao salvar o comentário tente novamente",
                    );
                } else {

                    $obj = Array(
                        'status' => true,
                        'message' => "Comentário feito com sucesso",
                    );
                }
            }
        } else {

            $obj = Array(
                'status' => false,
                'message' => "Erro ao comentar, tente atualizar a sua página",
            );
        }

        RotaController::res($obj);
    }

    public static function setCurtir() {

        $temp = DBController::init();
        $publicacao = $temp->db_publicacao;
        $user = SessionController::get("user");

        foreach (iterator_to_array($publicacao->find(['_id' => new MongoId($_POST['token'])])) as $value) {

            $status = true;

            foreach ($value['curtir'] as $parseCurtir) {

                if ($parseCurtir == $user['token']) {
                    $status = false;
                }

                $obj[] = $parseCurtir;
            }

            if ($status == true) {
                $obj[] = $user['token'];
            }

            $cursor2 = $publicacao->update(
                    Array(
                '_id' => new MongoId($_POST['token'])), Array(
                "naoCurtir" => $value['naoCurtir'],
                "curtir" => ($status == true ? $obj : $value['curtir']),
                "comentarios" => $value['comentarios'],
                "user_token" => $value['user_token'],
                "post" => $value['post'],
                "data" => $value["data"]));
        }

        if ($cursor2['ok'] == true && $status == true) {

            $obj = Array(
                'status' => true,
                'message' => "Ei, você curtiu!",
            );
        } else {

            $obj = Array(
                'status' => false,
                'message' => ($status == false ? "ei! você ja curtiu esse POST" : 'Algum problema aconteceu ao curtir')
            );
        }

        RotaController::res($obj);
    }

    public static function setNaoCurtir() {

        $temp = DBController::init();
        $publicacao = $temp->db_publicacao;
        $user = SessionController::get("user");

        foreach (iterator_to_array($publicacao->find(['_id' => new MongoId($_POST['token'])])) as $value) {

            $status = true;

            foreach ($value['naoCurtir'] as $parseCurtir) {

                if ($parseCurtir == $user['token']) {
                    $status = false;
                }

                $obj[] = $parseCurtir;
            }

            if ($status == true) {
                $obj[] = $user['token'];
            }

            $cursor2 = $publicacao->update(
                    Array(
                '_id' => new MongoId($_POST['token'])), Array(
                "curtir" => $value['curtir'],
                "naoCurtir" => ($status == true ? $obj : $value['naoCurtir']),
                "comentarios" => $value['comentarios'],
                "user_token" => $value['user_token'],
                "post" => $value['post'],
                "data" => $value["data"]));
        }

        if ($cursor2['ok'] == true && $status == true) {

            $obj = Array(
                'status' => true,
                'message' => "Ei, você curtiu o Não Curtiu HAHA!",
            );
        } else {

            $obj = Array(
                'status' => false,
                'message' => ($status == false ? "ei! você ja curtiu o NÃO CURTIU desse POST" : 'Algum problema aconteceu ao não curtir')
            );
        }

        RotaController::res($obj);
    }

    public static function getPublicacoes() {

        $res = Array();
        $temp = DBController::init();
        $publicacao = $temp->db_publicacao;
        
        $user = SessionController::get("user");

        $obj = iterator_to_array($publicacao->find());

        foreach ($obj as $key => $value) {

            $value['proprietario'] = ($user['token'] == $value['user_token'] ? true : false);
            $value['token'] = $key;
            $value['curtirTotal'] = count($value['curtir']);
            $value['naoCurtirTotal'] = count($value['naoCurtir']);
            $value['comentariosTotal'] = count($value['comentarios']);

            $res[] = $value;
        }

        RotaController::res($res);
    }

    public static function isMyPublicacao($id) {

        $temp = DBController::init();
        $publicacao = $temp->db_publicacao;

        $user = SessionController::get("user");

        $obj = iterator_to_array($publicacao->find(['_id' => new MongoId($id)]));

        foreach ($obj as $value) {

            if ($value['user_token'] == $user['token'] ? true : false) {

                $publicacao->remove(['_id' => new MongoId($id)]);

                return true;
            }

            return false;
        }
    }

    public static function actionNew() {

        $user = SessionController::get("user");

        if (empty($user) == false && empty($_POST['publicacao']) == false && empty($user['token']) == false) {

            $temp = DBController::init();
            $publicar = $temp->db_publicacao;

            $all = $publicar->save(
                    Array(
                        "naoCurtir" => Array(),
                        "curtir" => Array(),
                        "comentarios" => Array(),
                        "user_token" => $user['token'],
                        "post" => $_POST['publicacao'],
                        "data" => date("H") . "h" . date("i") . ' ' . date("d/m/Y")
            ));

            if ($all['ok'] == true) {

                $obj = Array(
                    'status' => true,
                    'message' => 'registro feito com sucesso'
                );
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
