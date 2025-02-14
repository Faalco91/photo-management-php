<?php
class HomeController extends Controller {
    public function index() {
        $data = [
            'title' => 'Accueil',
            'username' => isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''
        ];
        
        $this->view('home/index', $data);
    }
}