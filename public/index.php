<?php
// Démarrer la session avant toute sortie
session_start();

// Définir le chemin de base
define('ROOT', dirname(__DIR__) . '/app');
define('BASE_URL', 'http://localhost:8081');

// Charger la configuration
require_once ROOT . '/config/config.php';

// Charger les classes de base
require_once ROOT . '/core/Controller.php';
require_once ROOT . '/core/Database.php';
require_once ROOT . '/core/Router.php';

// Gérer la requête
$router = new Router();
$router->handleRequest();