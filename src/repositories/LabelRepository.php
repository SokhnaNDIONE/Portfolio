<?php

namespace App\repositories;
use App\models\Label;


class LabelRepository extends AbstractRepository {
    
    
   //---- Récupérer les labels d'un projet spécifique ----//
    public function getLabelsByProjectId(int $projectId): array {
        return $this->getAll(
        "SELECT labels.* FROM labels 
         JOIN projects_labels ON labels.id = projects_labels.label_id 
         WHERE projects_labels.project_id = :project_id",
        ['project_id' => $projectId]
        );
    }
    
    
    //---- Récupérer tous labels ----//
    public function getAllLabels(): array {
        return $this->getAll("SELECT * FROM labels");
    }


}