<?php

use Model\Activerecord;
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'config/database.php';


//Conectando a la base de datos
$db = conectarDB();



Activerecord::setDB($db);


