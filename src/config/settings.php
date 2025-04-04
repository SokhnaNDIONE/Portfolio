<?php

declare(strict_types=1);

// Définition des routes
const AVAILABLE_ROUTES = [
    'home' => 'HomeController',
    'login' => 'LoginController',
    'loginProcess' => 'LoginController', 
    'logout' => 'LoginController',
    'projectDetails' => 'ProjectController',
    'admin' => 'AdminController',
    'editProfile' => 'EditProfileController',
    'error' => 'ErrorController',
    'createProject' => 'AdminController',
    'deleteProject' => 'AdminController',
    'editProject' => 'EditProjectController'
];

// Route par défaut
const DEFAULT_ROUTE = 'home';