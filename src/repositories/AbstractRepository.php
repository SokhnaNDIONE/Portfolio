<?php

namespace App\repositories;
require_once "src/services/database.php";


abstract class AbstractRepository {

    protected $db;

    // Initialiser la connexion à la base de données
    public function __construct() {
        $this->db = getConnexion();
    }
    

    // Exécution d'une requête SELECT avec un seul résultat
    protected function getOne(string $query, array $params = []): array|bool {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(); 
    }


    // Exécution d'une requête SELECT avec plusieurs résultats
    protected function getAll(string $query, array $params = []): array {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(); 
        
    }
    

    // --- Exécution d'une requête INSERT --- //
    protected function insert(string $query, array $params): bool{
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params); 
    }
    
    
    // --- Exécution d'une requête UPDATE ou DELETE --- //
    protected function execute(string $query, array $params): bool{
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params); 
    }
    
    
}