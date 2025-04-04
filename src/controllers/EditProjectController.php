<?php
namespace App\controllers;

use App\repositories\ProjectRepository;
use App\repositories\CategoryRepository;
use App\repositories\LabelRepository;

use App\models\Project;

class EditProjectController {
    
    // ---- Afficher formulaire de modification d'un projet -- //
    public function displayEditProject(int $projectId) {
        
        // Récupération des données nécessaires
        $projectRepo = new ProjectRepository();
        $project = $projectRepo->getOneProject($projectId);
        
        if (!$project) {
            $_SESSION['error'] = "Le projet avec l'ID $projectId n'existe pas.";
        }

        // Récupérer les catégories et les labels
        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->getAllCategories();
        
        $labelRepo = new LabelRepository();
        $labels = $labelRepo->getAllLabels();
        
        // Passer les données à la vue
        $template = "projects/editProject"; 
        require "src/views/layout.phtml"; 
    }
    
    
    
    // --- Fonction pour soumettrele formulaire d'édition ---- //
    public function submitEditProject(int $projectId) {
        
        if (!(empty($_POST))) {
            
            // Récupération des champs du formulaire
            $title = $_POST['title'];
            $description = $_POST['description'];
            $categoryId = $_POST['category_id'];
            $labels = $_POST['labels'] ?? [];
    
    
            // Traitement de l'image
            $imagePath = $_POST['current_image'] ?? ''; // par défaut, on garde l'image actuelle
    
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'src/assets/img/';
                $filename = basename($_FILES['image']['name']);
                $destination = $uploadDir . $filename;
    
                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $imagePath = $filename;
                }
            }
    
            // Mettre à jour le projet
            $project = new Project($projectId, $title, $imagePath, $description, $categoryId, $_SESSION['user_id']);
            $projectRepo = new ProjectRepository();
            $projectRepo->updateProject($project);
    
            // Mise à jour des labels liés au projet
            $projectRepo->updateProjectLabels($projectId, $labels);
    
            // Après avoir supprimé le projet avec succès
            $_SESSION['success_message'] = 'Ton projet est modifié avec succès !';
            // Redirection vers la page d'admin
            header("Location: index.php?route=admin");
            exit();
        }
    }

}
