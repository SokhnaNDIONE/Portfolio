<?php

declare(strict_types=1);

namespace App\services;

class Router{
    
    private $controller;

    public function __construct($page){
        
        // Vérifier si la route existe dans AVAILABLE_ROUTES
        if (!array_key_exists($page, AVAILABLE_ROUTES)) {
            throw new \Exception("Route non trouvée : $page");
        }
        $this->controller = AVAILABLE_ROUTES[$page];
    }

    public function getController(): object{
        
        $instance = "App\\controllers\\" . $this->controller;
        if (!class_exists($instance)) {
            throw new \Exception("Classe non trouvée : $instance");
        }
        
        return new $instance();
    }
}