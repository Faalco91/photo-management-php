<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// D�marrer la session avant toute sortie
session_start();

// D�finir le chemin de base
define('ROOT', dirname(__DIR__) . '/app');
define('BASE_URL', 'http://localhost:8081');

// Charger la configuration
require_once ROOT . '/config/config.php';

// Charger les classes de base
require_once ROOT . '/core/Controller.php';
require_once ROOT . '/core/Database.php';
require_once ROOT . '/core/Router.php';

// G�rer la requ�te
$router = new Router();
$router->handleRequest();
