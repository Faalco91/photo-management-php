<?php
/**
 * Classe de gestion de la base de données
 */
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $dbh;
    private $stmt;
    private $error;

    public function __construct() {
        // Configuration DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );

        // Création de l'instance PDO
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            throw new Exception($this->error);
        }
    }

    /**
     * Prépare une requête
     */
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Bind des valeurs
     */
    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Exécute la requête préparée
     */
    public function execute() {
        return $this->stmt->execute();
    }

    /**
     * Récupère tous les enregistrements
     */
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    /**
     * Récupère un seul enregistrement
     */
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    /**
     * Récupère le nombre de lignes
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    /**
     * Récupère le dernier ID inséré
     */
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

    /**
     * Démarre une transaction
     */
    public function beginTransaction() {
        return $this->dbh->beginTransaction();
    }

    /**
     * Commit une transaction
     */
    public function commit() {
        return $this->dbh->commit();
    }

    /**
     * Rollback une transaction
     */
    public function rollBack() {
        return $this->dbh->rollBack();
    }
}
