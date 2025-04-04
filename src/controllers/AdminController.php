<?php
namespace App\controllers;

use App\repositories\UserRepository;
use App\repositories\ProjectRepository;
use App\repositories\SkillRepository;
use App\repositories\CategoryRepository;
use App\repositories\LabelRepository;
use App\models\Project;

class AdminController {
    
    
    // ---- Afficher la page admin ----- //
    public function displayDashboard() {
        // Vérification de connexion
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        // Récupération des données nécessaires
        $repoUser = new UserRepository();
        $user = $repoUser->getUserByEmail("sonia.jeon@example.com");

        $repoProject = new ProjectRepository();
        $projects = $repoProject->getAllProjects();
    
        $repoCategory = new CategoryRepository();
        $categories = $repoCategory->getAllCategories(); 
        
        $repoSkill = new SkillRepository();
        $skills = $repoSkill->getAllSkills();

        $template = "admin/admin";
        require "src/views/layout.phtml";
    }
    
    
    // ----- Fonction pour supprimer projet ----- //
    public function deleteProject(int $projectId) {
        
        if (!(empty($_POST))) {
        
            // Appeler la méthode de suppression
            $repoProject = new ProjectRepository();
            $repoProject->deleteProjectByProjectId($projectId);
    
            // Après avoir supprimé le projet avec succès
            $_SESSION['success_message'] = 'Le projet a été supprimé avec succès !';
            // Rediriger vers la page d'administration
            header("Location: index.php?route=admin");
            exit();
         }
    }

    // ------ Afficher le formulaire d'ajout de projet --- //
    public function displayAddForm() {
        
        // Vérifier si l'utilisateur est connecté, sinon rediriger vers login
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        // Récupérer les catégories et labels pour le formulaire
        $repoCategory = new CategoryRepository();
        $categories = $repoCategory->getAllCategories();

        $repoLabel = new LabelRepository();
        $labels = $repoLabel->getAllLabels();

        $template = "projects/createProject";
        require "src/views/layout.phtml";
    }


    // ----- Fonction pour ajouter un projet --- //
    public function addProject() {
        
        if (!(empty($_POST))) {
            
            // Récupérer les données saisies
            $title = $_POST['title'];
            $description = $_POST['description'];
            $categoryId = $_POST['category_id'];
            $labels = $_POST['labels'] ?? [];
    
            // Définir une image par défaut
            $imagePath = 'src/assets/img/coding-background-9izlympnd0ovmpli.jpg';
    
            // Vérifier si une image a été téléchargée
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                
                $imageTmpPath = $_FILES['image']['tmp_name'];
                $imageName = $_FILES['image']['name'];
                $imageDestination = 'src/assets/img/' . basename($imageName);
    
                // Ajouter l'image dans le dossier de destiation en vérifiant s'il existe
                if (move_uploaded_file($imageTmpPath, $imageDestination)) {
                    $imagePath = $imageDestination; // Mettre à jour l'image si l'upload réussit
                }
            }
    
            // Vérifier que $imagePath est bien une chaîne valide avant de l'afficher
            if (!is_string($imagePath) || empty($imagePath)) {
                $imagePath = 'src/assets/img/coding-background-9izlympnd0ovmpli.jpg';
            }
    
            // Création du projet avec l'instanciation de la classe Project
            $project = new Project(0, $title, $imagePath, $description, $categoryId, $_SESSION['user_id']);
            
            
            // Insérer les labels et projets
            $repoProject = new ProjectRepository();
            $projectId = $repoProject->insertProjectWithLabels($project, $labels);
            
            // Après avoir ajouté le projet avec succès
            $_SESSION['success_message'] = 'Le projet a été ajouté avec succès !';
            // Rediriger vers l'admin après l'ajout
            header("Location: index.php?route=admin");
            exit();
        }
    }


}
