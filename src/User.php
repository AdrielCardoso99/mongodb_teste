<?php

Class User{
    
    private $nome;
    private $pass;
    private $email;
    
    function getNome() {
        return $this->nome;
    }

    function getPass() {
        return $this->pass;
    }

    function getEmail() {
        return $this->email;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function setEmail($email) {
        $this->email = $email;
    }


}
