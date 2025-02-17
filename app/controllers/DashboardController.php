<?php
// app/controllers/DashboardController.php

class DashboardController extends Controller {
    private $groupModel;
    private $photoModel;

    public function __construct() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
        $this->groupModel = $this->model('Group');
        $this->photoModel = $this->model('Photo');
    }

    public function index() {
        // Récupérer les groupes de l'utilisateur
        $groups = $this->groupModel->getUserGroups($_SESSION['user_id']);
        
        $data = [
            'groups' => $groups,
            'username' => $_SESSION['user_name']
        ];
        
        $this->view('dashboard/index', $data);
    }
}