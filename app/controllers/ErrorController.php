<?php
class ErrorController extends Controller {
    public function index() {
        $data = ['message' => 'Page non trouvée'];
        $this->view('error/404', $data);
    }
}