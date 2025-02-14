<?php
class Router {
    protected $currentController = 'HomeController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function handleRequest() {
        // R�cup�rer l'URL depuis la requ�te
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($url, '/');
        $url = $url ? explode('/', $url) : [];

        error_log('URL compl�te : ' . $_SERVER['REQUEST_URI']);
        error_log('URL pars�e : ' . print_r($url, true));

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
            }
        }

        // Reste = param�tres
        $this->params = $url ? array_values($url) : [];
        error_log('Param�tres : ' . print_r($this->params, true));

        // Appel du contr�leur
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }
}