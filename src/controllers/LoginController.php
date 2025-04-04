<?php
namespace App\controllers;

use App\repositories\UserRepository;
use Exception; // Ajout de l'import
use Throwable; // Ajout de l'import

class LoginController {
    
    
    // ----- Afficher le formulaire de connexion ---- //
    public function displayLogin() {
        $template = "admin/login";
        require "src/views/layout.phtml";
    }
    
    
    
    
    //----- Fonction pour gérer la page de connexion ----- //
    public function loginProcess() {
        
        if(!empty($_POST)){
            
            //de quoi j'ai besoin ? (des données)
            $repoUser = new UserRepository();
            $user = $repoUser->getUserByEmail("sonia.jeon@example.com");
                
            try {
                
                // Vérifier si les données saisies sont correctes 
                if($user && password_verify($_POST["password"], $user->getPassword()) && $_POST["email"] === $user->getEmail()) {
                    
                        // Stocker les données user_id et l'email dans la session courante
                        $_SESSION["user_id"] = $user->getId();
                        $_SESSION["user"] = $user->getEmail();
                        $_SESSION["isAdmin"] = true; 
                            
                        header("Location: index.php?route=admin");
                        exit;
                    } 
                    else {
                        throw new Exception("Identifiant ou mot de passe incorrect");
                    }
                    
                } catch(Throwable $e) {
                    
                    $_SESSION['login_error'] = $e->getMessage();
                    header("Location: index.php?route=login");
                    exit;
                }
        }
        
        // Si pas de POST ou erreur, rediriger vers login
        header("Location: index.php?route=login");
        exit;
    }
    
    
    
    
    // ---- Fonction qui gére la deconnexion ---- //
    public function logout() {
        session_unset();  // Vide toutes les variables de session
        session_destroy(); // Détruit la session
        header('Location: index.php');
        exit;
    }
}