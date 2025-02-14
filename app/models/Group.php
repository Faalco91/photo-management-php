<?php
class Group {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function createGroup($data) {
        $this->db->beginTransaction();

        try {
            // Création du groupe
            $this->db->query('INSERT INTO `groups` (name, description, owner_id) VALUES (:name, :description, :owner_id)');
            
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':owner_id', $data['owner_id']);
            
            $this->db->execute();
            $groupId = $this->db->lastInsertId();

            // Ajout du propriétaire comme membre
            $this->db->query('INSERT INTO user_groups (user_id, group_id, role) VALUES (:user_id, :group_id, "owner")');
            
            $this->db->bind(':user_id', $data['owner_id']);
            $this->db->bind(':group_id', $groupId);
            
            $this->db->execute();
            $this->db->commit();

            return $groupId;
        } catch(Exception $e) {
            $this->db->rollBack();
            error_log('Erreur lors de la création du groupe: ' . $e->getMessage());
            return false;
        }
    }

    public function getUserGroups($userId) {
        $this->db->query('SELECT g.*, ug.role 
                         FROM `groups` g 
                         JOIN user_groups ug ON g.id = ug.group_id 
                         WHERE ug.user_id = :user_id
                         ORDER BY g.created_at DESC');
        
        $this->db->bind(':user_id', $userId);

        return $this->db->resultSet();
    }

    public function getGroupById($id) {
        $this->db->query('SELECT * FROM `groups` WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getGroupMembers($groupId) {
        $this->db->query('SELECT u.id, u.username, u.email, ug.role 
                         FROM users u 
                         JOIN user_groups ug ON u.id = ug.user_id 
                         WHERE ug.group_id = :group_id');
        
        $this->db->bind(':group_id', $groupId);
        return $this->db->resultSet();
    }

    public function isMember($groupId, $userId) {
        $this->db->query('SELECT * FROM user_groups 
                         WHERE group_id = :group_id AND user_id = :user_id');
        
        $this->db->bind(':group_id', $groupId);
        $this->db->bind(':user_id', $userId);

        return ($this->db->single()) ? true : false;
    }
}