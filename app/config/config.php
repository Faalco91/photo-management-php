<?php
// app/config/config.php

require __DIR__ . '/../../vendor/autoload.php';

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Constantes de configuration pour Mailgun
define('MAILGUN_API_KEY', $_ENV['MAILGUN_API_KEY']);
define('MAILGUN_DOMAIN', $_ENV['MAILGUN_DOMAIN']);
define('MAILGUN_FROM_EMAIL', $_ENV['MAILGUN_FROM_EMAIL']);
define('MAILGUN_FROM_NAME', $_ENV['MAILGUN_FROM_NAME']);

// Configuration de la base de donn�es
define('DB_HOST', 'db');
define('DB_USER', 'roadtrip_user');
define('DB_PASS', 'roadtrip_pass');
define('DB_NAME', 'roadtrip_db');

// Mode debug
define('DEBUG_MODE', true);

// V�rification des chemins critiques
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $criticalPaths = [
        'views' => ROOT . '/views',
        'layouts' => ROOT . '/views/layouts',
        'header' => ROOT . '/views/layouts/header.php',
        'footer' => ROOT . '/views/layouts/footer.php'
    ];

    foreach ($criticalPaths as $name => $path) {
        if (!file_exists($path)) {
            error_log("Critical path not found: $name => $path");
        }
    }
}