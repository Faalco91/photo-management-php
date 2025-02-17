<?php
// app/core/Controller.php
class Controller {
    public function model($model) {
        // Chemin complet vers le modèle
        $modelFile = ROOT . '/models/' . $model . '.php';
        
        // Vérifier si le fichier existe
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        }
        throw new Exception("Model $model not found ($modelFile)");
    }

    public function view($view, $data = []) {
        // Chemin complet vers la vue
        $viewFile = ROOT . '/Views/' . $view . '.php';
        $headerFile = ROOT . '/Views/layouts/header.php';
        $footerFile = ROOT . '/Views/layouts/footer.php';
        
        // Vérifier si la vue existe
        if (!file_exists($viewFile)) {
            die("View not found: " . $viewFile);
        }

        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);

        // Charger le header s'il existe
        if (file_exists($headerFile)) {
            require $headerFile;
        }

        // Charger la vue principale
        require $viewFile;

        // Charger le footer s'il existe
        if (file_exists($footerFile)) {
            require $footerFile;
        }
    }
}