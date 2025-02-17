<?php
// app/core/Controller.php
class Controller {
    public function model($model) {
        // Chemin complet vers le mod�le
        $modelFile = ROOT . '/models/' . $model . '.php';
        
        // V�rifier si le fichier existe
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        }
        throw new Exception("Model $model not found ($modelFile)");
    }

    public function view($view, $data = []) {
        // Chemin complet vers la vue
        $viewFile = ROOT . '/views/' . $view . '.php';
        
        // V�rifier si la vue existe
        if (!file_exists($viewFile)) {
            die("View not found: " . $viewFile);
        }

        // Extraire les donn�es pour les rendre disponibles dans la vue
        extract($data);

        // Charger la vue principale
        require $viewFile;
    }
}