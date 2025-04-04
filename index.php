<?php

declare(strict_types=1);

use App\controllers\HomeController;
use App\repositories\UserRepository; 
use App\services\Router;

session_start();

// Fichier où sont définies AVAILABLE_ROUTES et DEFAULT_ROUTE
require_once 'src/config/settings.php'; 
require_once 'src/services/Router.php';


// ----- Autoload ----- //
spl_autoload_register(function ($classname) {
    $path = str_replace('\\', '/', $classname);
    $path = str_replace('App', 'src', $path);
    $filename = $path . '.php';
    if (file_exists($filename)) {
        include $filename;
    }
});

date_default_timezone_set('Europe/Paris'); 



// --- Valider et nettoyer l'entrée utilisateur --- //
$url = isset($_GET['route']) ? trim($_GET['route']) : DEFAULT_ROUTE;

try {
    // Créer le routeur
    $router = new Router($url);

    // Instancier le contrôleur
    $controllerInstance = $router->getController();

    switch ($url) {
    
    case 'home':
        $controllerInstance->display();
        break;
    case 'login':
        if (!(empty($_POST))) {
            $controllerInstance->loginProcess();
        } else {
            $controllerInstance->displayLogin();
        }
        break;
    case 'loginProcess':
        $controllerInstance->loginProcess();
        break;
    case 'logout':
        $controllerInstance->logout();
        break;
    case 'admin':
        $controllerInstance->displayDashboard();
        break;
    case 'editProfile':
        $controllerInstance->displayEditProfile();
        break;
        
    case 'projectDetails':
        $projectId = isset($_GET['projectId']) ? (int)$_GET['projectId'] :  0;
        $controllerInstance->displayProject($projectId);
        break;
        
    case 'error':
        $controllerInstance->error();
        break;
        
    case 'createProject':
        if (!(empty($_POST))) {
            $controllerInstance->addProject();  // Traitement du formulaire
        } else {
            $controllerInstance->displayAddForm();  // Affichage du formulaire
        }
    break;
    
    case 'editProject':
        $projectId = isset($_GET['projectId']) ? (int)$_GET['projectId'] :  0;
        if (!(empty($_POST))) {
            $controllerInstance->submitEditProject($projectId);
        } else {
            $controllerInstance->displayEditProject($projectId); 
        }
    break;
    
    case 'deleteProject':
        $projectId = isset($_GET['projectId']) ? (int)$_GET['projectId'] :  0;
        $controllerInstance->deleteProject($projectId);  
        break;

    
    default:
        header("Location: index.php?route=error");
        exit();
    }
    
} catch (\Exception $e) {
    // // Rediriger vers la page d'accueil
    header("Location: index.php?route=error");
    exit();
     
}