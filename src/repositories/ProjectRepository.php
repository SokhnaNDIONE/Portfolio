<?php

namespace App\repositories;
use App\models\Project;
use Exception;

class ProjectRepository extends AbstractRepository {
    
    // ----- Récupérer tous les Projects ----- //
    public function getAllProjects(): array {
    return $this->getAll("
        SELECT projects.*, 
               categories.name AS category_name, 
               GROUP_CONCAT(labels.name SEPARATOR ', ') AS labels
        FROM projects
        LEFT JOIN categories ON projects.category_id = categories.id
        LEFT JOIN projects_labels ON projects.id = projects_labels.project_id
        LEFT JOIN labels ON projects_labels.label_id = labels.id
        GROUP BY projects.id ");
    }

    
    
    //---- Récupérer un projet spécifique ----//
    public function getOneProject(int $projectId){
        return $this->getOne(
            "SELECT * FROM projects WHERE id = :id",
            ['id' => $projectId]
        );
    }



    // ----- Supprimer un projet par son id ------ //
    public function deleteProjectByProjectId(int $projectId): bool{
        return $this->execute(
            "DELETE FROM `projects` WHERE id = :id",
            ['id' => $projectId]
        );
    }

   
   
   
    // ----Insertion d'un projet avec les labels associés --- //
    public function insertProjectWithLabels(Project $project, array $labels): void {
        // Insérer le projet
        $this->insert("INSERT INTO projects (title, image, description, category_id, user_id) 
                       VALUES (:title, :image, :description, :category_id, :user_id)", [
            'title' => $project->getTitle(),
            'image' => $project->getImage(),
            'description' => $project->getDescription(),
            'category_id' => $project->getCategoryId(),
            'user_id' => $project->getUserId(),
        ]);
    
        // Récupérer l'ID du dernier projet inséré
        $projectId = $this->db->lastInsertId();
    
        // Insertion des labels associés
        foreach ($labels as $labelId) {
            $this->execute(
                "INSERT INTO projects_labels (project_id, label_id) VALUES (:project_id, :label_id)",
                ['project_id' => $projectId, 'label_id' => $labelId]
            );
        }
    }

    
 
    // ----- Modifier un projet ------ //
    public function updateProject(Project $project): bool {
        return $this->execute(
            "UPDATE projects SET title = :title, image = :image, description = :description, category_id = :category_id WHERE id = :id",
            [
                'id' => $project->getId(),
                'title' => $project->getTitle(),
                'image' => $project->getImage(),
                'description' => $project->getDescription(),
                'category_id' => $project->getCategoryId()
            ]
        );
    }
    
    
    
    
    // ---- Mettre à jour les labels associés à un projet ---- //
    public function updateProjectLabels(int $projectId, array $labels): bool {
        // Supprimer les anciens labels associés au projet
        $this->execute("DELETE FROM projects_labels WHERE project_id = :project_id", [
            'project_id' => $projectId
        ]);

        // Ajouter les nouveaux labels
        foreach ($labels as $labelId) {
            $this->execute("INSERT INTO projects_labels (project_id, label_id) VALUES (:project_id, :label_id)", [
                'project_id' => $projectId,
                'label_id' => $labelId
            ]);
        }

        return true;
    }


    // Méthode pour récupérer les projets d'une catégorie spécifique
    public function getProjectsByCategoryId(int $categoryId): array {
        return $this->getAll(
            "SELECT * FROM projects WHERE category_id = :category_id",
            ['category_id' => $categoryId]
        );
    }
}
