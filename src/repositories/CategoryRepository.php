<?php

namespace App\repositories;
use App\models\Category;

class CategoryRepository extends AbstractRepository {

    // ----- Récupérer tous les categories ----- //
    public function getAllCategories(): array {
        return $this->getAll("SELECT * FROM categories");
    }
    

    // Récupérer une catégorie spécifique par ID
    public function getCategoryById(int $categoryId) {
        return $this->getOne(
            "SELECT * FROM categories WHERE id = :id",
            ['id' => $categoryId]
        );
    }
    

}