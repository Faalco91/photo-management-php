<?php
class Router {
    protected $currentController = 'HomeController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function handleRequest() {
        // Récupérer l'URL depuis la requête
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($url, '/');
        $url = $url ? explode('/', $url) : [];

        error_log('URL complète : ' . $_SERVER['REQUEST_URI']);
        error_log('URL parsée : ' . print_r($url, true));

        // Premier segment = contrôleur
        if(!empty($url[0])) {
            $controllerName = ucwords($url[0]) . 'Controller';
            $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
            
            error_log('Recherche du contrôleur : ' . $controllerFile);
            
            if(file_exists($controllerFile)) {
                $this->currentController = $controllerName;
                unset($url[0]);
                error_log('Contrôleur trouvé : ' . $this->currentController);
            } else {
                error_log('Contrôleur non trouvé, utilisation du contrôleur par défaut');
            }
        }

        // Charger le contrôleur
        require_once ROOT . '/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        // Deuxième segment = méthode
        if(!empty($url[1])) {
            if(method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
                error_log('Méthode trouvée : ' . $this->currentMethod);
            }
        }

        // Reste = paramètres
        $this->params = $url ? array_values($url) : [];
        error_log('Paramètres : ' . print_r($this->params, true));

        // Appel du contrôleur
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }
}