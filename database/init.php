<?php
require_once dirname(__DIR__) . '/app/config/config.php';

try {
    // Connexion au serveur MySQL
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Sélectionner la base de données
    $pdo->exec("USE " . DB_NAME);
    
    // Lecture du fichier SQL
    $sql = file_get_contents(__DIR__ . '/schema.sql');
    
    // Exécution des requêtes SQL
    $result = $pdo->exec($sql);
    
    echo "Base de données initialisée avec succès!\n";
    echo "Résultat de l'exécution : " . $result . "\n";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}