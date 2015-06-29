<?php

Class MainController{
    
    public function __construct() {
        
        switch (strtolower(@$_POST['action'])) {
            
            case "user": UserController::init();
                break;
            case "publicar": PublicacaoController::init();
                break;
        }
    }
}
