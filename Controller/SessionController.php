<?php

Class SessionController{
    
    public static function set($key, $value){
        
        @session_start();
        
        $_SESSION[$key] = $value;
    }
    
    public static function get($key){
        
        @session_start();
        
        return (@$_SESSION[$key] ? @$_SESSION[$key] : "");
    }
    
    public static function destroy($key){
        
        @session_start();
        $_SESSION[$key] = "";
        unset($_SESSION[$key]);
    }
}

