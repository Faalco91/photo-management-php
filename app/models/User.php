<?php
class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Méthode de login
    public function login($email, $password) {
        try {
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
            $row = $this->db->single();

            if ($row) {
                if (password_verify($password, $row->password)) {
                    return $row;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log('Erreur SQL lors de la connexion: ' . $e->getMessage());
            return false;
        }
    }

    // Vérifier si un email existe
    public function findUserByEmail($email) {
        try {
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
            $row = $this->db->single();
            
            error_log('Recherche email ' . $email . ' : ' . ($row ? 'trouvé' : 'non trouvé'));
            
            return ($row) ? true : false;
        } catch (PDOException $e) {
            error_log('Erreur SQL lors de la vérification email: ' . $e->getMessage());
            return false;
        }
    }

    // Inscription d'un nouvel utilisateur
    public function register($data) {
        try {
            error_log('Tentative d\'inscription avec les données : ' . print_r($data, true));
            $this->db->query('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
            
            // Bind des valeurs
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));

            // Exécuter
            $result = $this->db->execute();
            
            if (!$result) {
                error_log('Échec de l\'insertion : ' . print_r($this->db->error(), true));
                return false;
            }

            error_log('Inscription réussie');
            return true;
        } catch (PDOException $e) {
            error_log('Erreur SQL lors de l\'inscription: ' . $e->getMessage());
            return false;
        }
    }
}