<?php

namespace App\models;
use App\repositories\ProjectRepository;

class Category extends BaseModel {
    private string $name;

    public function __construct(int $id, string $name) {
        parent::__construct($id);
        $this->name = $name;
    }
    
    // GETTERS
    public function getName(): string {
        return $this->name;
    }
    // SETTERS
    public function setName(string $name): void {
        $this->name = $name;
    }
    
    
    // Méthode pour récupérer les projets associés à cette catégorie
    public function getProjects() {
        $projectRepo = new ProjectRepository();
        return $projectRepo->getProjectsByCategoryId($this->id);
    }
}
