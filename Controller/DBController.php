<?php

Class DBController {

    public static function init() {

        $conexao = new MongoClient ();
        $db = $conexao->mongo_social;
        return $db;
    }

}
