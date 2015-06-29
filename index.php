<?php

ini_set('display_errors', 'off');
ini_set('session.gc_maxlifetime', 1260000);
date_default_timezone_set('America/Sao_Paulo');
//date_default_timezone_set("Brazil/East"); // para aws 
//date_default_timezone_set('UTC');

require './vendor/autoload.php';

$auto = new MainController();