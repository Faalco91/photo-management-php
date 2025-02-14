<?php
// app/config/config.php

// Configuration de la base de données
define('DB_HOST', 'db');
define('DB_USER', 'roadtrip_user');
define('DB_PASS', 'roadtrip_pass');
define('DB_NAME', 'roadtrip_db');

// Mode debug
define('DEBUG_MODE', true);

// Vérification des chemins critiques
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