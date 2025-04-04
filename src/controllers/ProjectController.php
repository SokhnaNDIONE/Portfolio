<?php
namespace App\controllers;
use App\repositories\UserRepository;
use App\repositories\ProjectRepository; 
use App\repositories\CategoryRepository;
use App\repositories\LabelRepository;



class ProjectController {
    
    
    // -------- Affichage des projets ------ //
    public function displayProject(int $projectId){
        
        // Récupération du projet spécifique par ID
        $repoProject = new ProjectRepository();
        $project = $repoProject->getOneProject($projectId);
        
        // Récupérer toutes les catégories
        $repoCategory = new CategoryRepository();
        $categories = $repoCategory->getAllCategories(); 
        
        
        // Récupérer les labels associés au projet
        $repoLabel = new LabelRepository();
        $labels = $repoLabel->getLabelsByProjectId($projectId);
        // Ajouter les labels à l'objet ou tableau du projet cad les transformer en objet
        $project['labels'] = $labels; 
           
        
        // Passer le projet et les labels à la vue
        $template = "projects/projectDetails";
        require "src/views/layout.phtml";
}

}