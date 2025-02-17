<?php
class Router {
    protected $currentController = 'HomeController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function handleRequest() {
        // R�cup�rer l'URL depuis la requ�te
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($url, '/');
        
        // Nettoyer les segments d'URL dupliqu�s
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
        
        error_log('URL compl�te : ' . $_SERVER['REQUEST_URI']);
        error_log('URL nettoy�e : ' . print_r($url, true));

        // Premier segment = contr�leur
        if(!empty($url[0])) {
            $controllerName = ucwords($url[0]) . 'Controller';
            $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
            
            error_log('Recherche du contr�leur : ' . $controllerFile);
            
            if(file_exists($controllerFile)) {
                $this->currentController = $controllerName;
                unset($url[0]);
                error_log('Contr�leur trouv� : ' . $this->currentController);
            } else {
                error_log('Contr�leur non trouv�, utilisation du contr�leur par d�faut');
                header('HTTP/1.0 404 Not Found');
                require_once ROOT . '/Views/error/404.php';
                exit();
            }
        }

        // Charger le contr�leur
        require_once ROOT . '/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        // Deuxi�me segment = m�thode
        if(!empty($url[1])) {
            if(method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
                error_log('M�thode trouv�e : ' . $this->currentMethod);
            } else {
                // Si la m�thode n'existe pas, v�rifier si register ou login existe
                if ($url[1] === 'register' && method_exists($this->currentController, 'register')) {
                    $this->currentMethod = 'register';
                    unset($url[1]);
                } elseif ($url[1] === 'login' && method_exists($this->currentController, 'login')) {
                    $this->currentMethod = 'login';
                    unset($url[1]);
                } else {
                    // Rediriger vers une page 404 si la m�thode n'existe pas
                    header('HTTP/1.0 404 Not Found');
                    require_once ROOT . '/Views/error/404.php';
                    exit();
                }
            }
        } else {
            // Si aucune m�thode n'est sp�cifi�e et que c'est AuthController
            if ($this->currentController instanceof AuthController) {
                $this->currentMethod = 'login'; // Utiliser login comme m�thode par d�faut pour AuthController
            }
        }

        // Reste = param�tres
        $this->params = $url ? array_values($url) : [];
        error_log('Param�tres : ' . print_r($this->params, true));

        // Appel du contr�leur
        if (method_exists($this->currentController, $this->currentMethod)) {
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        } else {
            // Si la m�thode n'existe toujours pas, afficher une erreur 404
            header('HTTP/1.0 404 Not Found');
            require_once ROOT . '/Views/error/404.php';
            exit();
        }
    }
}