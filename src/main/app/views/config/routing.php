<?php
/**
 * Système de routage
 */

class Router {
    private static $routes = [];
    private static $basePath = '/gestion_programme';
    
    public static function get($path, $handler) {
        self::$routes['GET'][$path] = $handler;
    }
    
    public static function post($path, $handler) {
        self::$routes['POST'][$path] = $handler;
    }
    
    public static function redirect($path) {
        $url = self::$basePath . $path;
        header("Location: $url");
        exit();
    }
    
    public static function url($path) {
        return self::$basePath . $path;
    }
    
    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        
        // Nettoyer l'URI
        $uri = str_replace(self::$basePath, '', $uri);
        $uri = strtok($uri, '?');
        
        // Gérer la racine
        if ($uri === '' || $uri === '/') {
            $uri = '/login';
        }
        
        // Vérifier si la route existe
        if (isset(self::$routes[$method][$uri])) {
            $handler = self::$routes[$method][$uri];
            
            if (is_callable($handler)) {
                return $handler();
            } elseif (is_string($handler) && strpos($handler, '@') !== false) {
                return self::renderController($handler);
            } elseif (is_string($handler)) {
                return self::renderView($handler);
            }
        }
        
        // Routes par défaut
        return self::handleDefaultRoutes($uri);
    }
    
    private static function renderController($handler) {
        list($controller, $method) = explode('@', $handler);
        
        $controllerFile = __DIR__ . "/../controllers/{$controller}.php";
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerClass = new $controller();
            return $controllerClass->$method();
        }
        
        return self::render404();
    }
    
    private static function handleDefaultRoutes($uri) {
        // Routes de connexion
        if ($uri === '/login') {
            return self::renderView('auth/login');
        }
        
        if ($uri === '/logout') {
            return self::renderView('auth/logout');
        }
        
        // Routes des dashboards
        $dashboardRoutes = [
            '/admin/dashboard' => 'admin/dashboard',
            '/enseignant/dashboard' => 'enseignant/dashboard',
            '/eleve/dashboard' => 'eleve/dashboard',
            '/directeur_discipline/dashboard' => 'directeur_discipline/dashboard',
            '/chef_classe/dashboard' => 'chef_classe/dashboard',
            '/prefet/dashboard' => 'prefet/dashboard',
            '/comite_parents/dashboard' => 'comite_parents/dashboard',
            '/tuteur/dashboard' => 'tuteur/dashboard'
        ];
        
        if (isset($dashboardRoutes[$uri])) {
            return self::renderView($dashboardRoutes[$uri]);
        }
        
        // Routes de test
        if ($uri === '/test') {
            return self::renderView('../test_dashboard');
        }
        
        if ($uri === '/test/interfaces') {
            return self::renderView('../test_interfaces');
        }
        
        return self::render404();
    }
    
    private static function renderView($viewPath) {
        $viewFile = __DIR__ . "/../views/{$viewPath}.php";
        
        if (file_exists($viewFile)) {
            ob_start();
            include $viewFile;
            return ob_get_clean();
        }
        
        return self::render404();
    }
    
    private static function render404() {
        http_response_code(404);
        return '<h1>Page non trouvée</h1><p>La page demandée n\'existe pas.</p>';
    }
    
    public static function getCurrentPath() {
        $uri = $_SERVER['REQUEST_URI'];
        return str_replace(self::$basePath, '', strtok($uri, '?'));
    }
    
    public static function isActive($path) {
        return self::getCurrentPath() === $path;
    }
}

// Définir les routes principales
Router::get('/', 'auth/login');
Router::get('/login', 'auth/login');
Router::get('/logout', 'auth/logout');
Router::post('/login', 'auth/login');
Router::post('/logout', 'auth/logout');

// Routes des dashboards
Router::get('/admin/dashboard', 'admin/dashboard');
Router::get('/enseignant/dashboard', 'enseignant/dashboard');
Router::get('/eleve/dashboard', 'eleve/dashboard');
Router::get('/directeur_discipline/dashboard', 'directeur_discipline/dashboard');
Router::get('/chef_classe/dashboard', 'chef_classe/dashboard');
Router::get('/prefet/dashboard', 'prefet/dashboard');
Router::get('/comite_parents/dashboard', 'comite_parents/dashboard');
Router::get('/tuteur/dashboard', 'tuteur/dashboard');

// Routes de test
Router::get('/test', '../test_dashboard');
Router::get('/test/interfaces', '../test_interfaces');
