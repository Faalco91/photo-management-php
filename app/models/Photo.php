<?php
class Photo {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    /**
     * Ajoute une nouvelle photo
     */
    public function addPhoto($data) {
        $this->db->query('INSERT INTO photos (user_id, group_id, filename, title, description, is_public) 
                         VALUES (:user_id, :group_id, :filename, :title, :description, :is_public)');
        
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':group_id', $data['group_id']);
        $this->db->bind(':filename', $data['filename']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':is_public', $data['is_public']);

        return $this->db->execute();
    }

    /**
     * Récupère toutes les photos d'un groupe
     */
    public function getPhotosByGroup($groupId) {
        $this->db->query('SELECT p.*, u.username 
                         FROM photos p 
                         JOIN users u ON p.user_id = u.id 
                         WHERE p.group_id = :group_id 
                         ORDER BY p.created_at DESC');
        
        $this->db->bind(':group_id', $groupId);
        return $this->db->resultSet();
    }

    /**
     * Récupère une photo par son ID
     */
    public function getPhotoById($id) {
        $this->db->query('SELECT p.*, u.username FROM photos p 
                         JOIN users u ON p.user_id = u.id 
                         WHERE p.id = :id');
        
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    /**
     * Supprime une photo
     */
    public function deletePhoto($id) {
        $this->db->query('DELETE FROM photos WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    /**
     * Vérifie si un utilisateur est propriétaire d'une photo
     */
    public function isOwner($photoId, $userId) {
        $this->db->query('SELECT * FROM photos WHERE id = :photo_id AND user_id = :user_id');
        $this->db->bind(':photo_id', $photoId);
        $this->db->bind(':user_id', $userId);

        return ($this->db->single()) ? true : false;
    }
}
