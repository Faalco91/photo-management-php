<?php
class HomeController extends Controller {
    public function index() {
        $data = [
            'title' => 'RoadPic',
            'username' => isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''
        ];
        
        $this->view('home/index', $data);
    }
}