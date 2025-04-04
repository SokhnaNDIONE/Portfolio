<?php

namespace App\repositories;
use App\models\User;

require "src/services/database.php";

class UserRepository {


    // ----- Récupérer User par son email ---- //
    public function getUserByEmail(string $email):User{
        $pdo = getConnexion();
        $query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$email]);
        
        //transformer les données en classe Model User
        $user = new User();
        $user->sanitize($query->fetch());
        return $user;
    }
    
    
    // ----- Récupérer User par son id ---- //
    public function getUserById(int $id):User{
        $pdo = getConnexion();
        $query = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $query->execute([$id]);
        
        //transformer les données en classe Model User
        $user = new User();
        $user->sanitize($query->fetch());
        return $user;
    }
    
    
    
    // ----- Modifier les données de User ---- //
    public function updateUser(User $user): void {
        $pdo = getConnexion();
        $query = $pdo->prepare('
            UPDATE users SET first_name = ?, last_name = ?, phone = ?, birthdate = ?, description = ?, photo = ? 
            WHERE id = ?
        ');
        
        // Exécuter la requête pour mettre à jour l'utilisateur
        $query->execute([
            $user->getFirstName(),
            $user->getLastName(),
            $user->getPhone(),
            $user->getBirthdate(),
            $user->getDescription(),
            $user->getPhoto(),
            $user->getId() // ID de l'utilisateur
        ]);
    }
    

    
}