<?php
class ErrorController extends Controller {
    public function index() {
        $data = ['message' => 'Page non trouv�e'];
        $this->view('error/404', $data);
    }
}