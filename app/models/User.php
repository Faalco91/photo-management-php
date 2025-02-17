<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }

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

    public function findUserByEmail($email) {
        try {
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
            $row = $this->db->single();
            
            error_log('Recherche email ' . $email . ' : ' . ($row ? 'trouvé' : 'non trouvé'));
            
            return $row; // Retourner l'objet utilisateur complet au lieu d'un booléen
        } catch (PDOException $e) {
            error_log('Erreur SQL lors de la vérification email: ' . $e->getMessage());
            return false;
        }
    }

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

    public function resetPassword($token, $password) {
        $this->db->query('SELECT * FROM users WHERE reset_token = :token AND reset_token_expires > NOW()');
        $this->db->bind(':token', $token);
        $row = $this->db->single();
        if ($row) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->db->query('UPDATE users SET password = :password, reset_token = NULL, reset_token_expires = NULL WHERE id = :id');
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':id', $row->id);
            return $this->db->execute();
        }
        return false;
    }

    public function storeResetToken($email, $token, $expires) {
        error_log("Storing reset token for $email: token=$token, expires=$expires");
        $this->db->query('UPDATE users SET reset_token = :token, reset_token_expires = :expires WHERE email = :email');
        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expires);
        $this->db->bind(':email', $email);
        $result = $this->db->execute();
        if (!$result) {
            error_log('Failed to store reset token: ' . print_r($this->db->error(), true));
        }
        return $result;    
    }

    public function findUserById($id) {
        try {
            $this->db->query('SELECT * FROM users WHERE id = :id');
            $this->db->bind(':id', $id);
            return $this->db->single();
        } catch (PDOException $e) {
            error_log('Erreur SQL lors de la recherche par ID: ' . $e->getMessage());
            return false;
        }
    }
}