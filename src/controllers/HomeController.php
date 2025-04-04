<?php
namespace App\controllers;

use App\repositories\UserRepository;
use App\repositories\ProjectRepository;
use App\repositories\CategoryRepository;
use App\repositories\SkillRepository;

class HomeController {
    
    public function display(){
        
        // Récupération de l'utilisateur
        $repoUser = new UserRepository();
        $user = $repoUser->getUserByEmail("sonia.jeon@example.com");

        // Récupération des projets
        $repoProject = new ProjectRepository();
        $projects = $repoProject->getAllProjects();

        // Récupérer toutes les catégories
        $repoCategory = new CategoryRepository();
        $categories = $repoCategory->getAllCategories(); 
        
        
        // Récupération des compétences
        $repoSkill = new SkillRepository();
        $skills = $repoSkill->getAllSkills();

        // Préparation des données pour la vue
        $template = "home/home"; // Le template à afficher
        require "src/views/layout.phtml"; // Inclure la vue générale
    }
}
