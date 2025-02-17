<?php
class Router {
    protected $currentController = 'HomeController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function handleRequest() {
        // Récupérer l'URL depuis la requête
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($url, '/');
        
        // Nettoyer les segments d'URL dupliqués
        $segments = $url ? explode('/', $url) : [];
        $cleanSegments = [];
        $seen = [];
        
        foreach ($segments as $segment) {
            if (!isset($seen[$segment])) {
                $cleanSegments[] = $segment;
                $seen[$segment] = true;
            }
        }
        
        $url = $cleanSegments;
        
        error_log('URL complète : ' . $_SERVER['REQUEST_URI']);
        error_log('URL nettoyée : ' . print_r($url, true));

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
                header('HTTP/1.0 404 Not Found');
                require_once ROOT . '/Views/error/404.php';
                exit();
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
            } else {
                // Si la méthode n'existe pas, vérifier si register ou login existe
                if ($url[1] === 'register' && method_exists($this->currentController, 'register')) {
                    $this->currentMethod = 'register';
                    unset($url[1]);
                } elseif ($url[1] === 'login' && method_exists($this->currentController, 'login')) {
                    $this->currentMethod = 'login';
                    unset($url[1]);
                } else {
                    // Rediriger vers une page 404 si la méthode n'existe pas
                    header('HTTP/1.0 404 Not Found');
                    require_once ROOT . '/Views/error/404.php';
                    exit();
                }
            }
        } else {
            // Si aucune méthode n'est spécifiée et que c'est AuthController
            if ($this->currentController instanceof AuthController) {
                $this->currentMethod = 'login'; // Utiliser login comme méthode par défaut pour AuthController
            }
        }

        // Reste = paramètres
        $this->params = $url ? array_values($url) : [];
        error_log('Paramètres : ' . print_r($this->params, true));

        // Appel du contrôleur
        if (method_exists($this->currentController, $this->currentMethod)) {
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        } else {
            // Si la méthode n'existe toujours pas, afficher une erreur 404
            header('HTTP/1.0 404 Not Found');
            require_once ROOT . '/Views/error/404.php';
            exit();
        }
    }
}