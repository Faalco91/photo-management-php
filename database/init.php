<?php
require_once dirname(__DIR__) . '/app/config/config.php';

try {
    // Connexion au serveur MySQL
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // S�lectionner la base de donn�es
    $pdo->exec("USE " . DB_NAME);
    
    // Lecture du fichier SQL
    $sql = file_get_contents(__DIR__ . '/schema.sql');
    
    // Ex�cution des requ�tes SQL
    $result = $pdo->exec($sql);
    
    echo "Base de donn�es initialis�e avec succ�s!\n";
    echo "R�sultat de l'ex�cution : " . $result . "\n";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}