<?php

namespace App\repositories;
use App\models\Skill;


class SkillRepository extends AbstractRepository{
    
        // ----- Récupérer tous les Skills ----- //
    public function getAllSkills(): array {
        return $this->getAll("SELECT * FROM skills");
    }
    
 

}