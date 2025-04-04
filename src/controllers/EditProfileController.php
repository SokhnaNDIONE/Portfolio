<?php

namespace App\controllers;
use App\repositories\UserRepository;
use App\models\User;
use DateTime;

class EditProfileController {


    // ----- Afficher formulaire édition profil ---- //
    public function displayEditProfile() {

        // Récupérer les données utilisateur
        $repoUser = new UserRepository();

        // On suppose que l'utilisateur est connecté, donc on peut récupérer son ID depuis la session
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        // Récupérer l'utilisateur connecté
        $user = $repoUser->getUserById($_SESSION['user_id']);

        // Vérifier si un formulaire a été soumis
        if (!(empty($_POST))) {
            
            // Validation des données du formulaire
            $error = [];

            // Validation prénom (doit contenir des lettres seulement)
            if (empty($_POST['first_name']) || !preg_match("/^[a-zA-Z]+$/", $_POST['first_name'])) {
                $error['first_name'] = "Le prénom doit contenir uniquement des lettres.";
            }

            // Validation nom (doit contenir des lettres seulement)
            if (empty($_POST['last_name']) || !preg_match("/^[a-zA-Z]+$/", $_POST['last_name'])) {
                $error['last_name'] = "Le nom doit contenir uniquement des lettres.";
            }

            // Validation téléphone (doit être un numéro valide)
            if (empty($_POST['phone']) || !preg_match("/^(\+?[0-9]{1,4})?[\s-]?[0-9]{1,4}[\s-]?[0-9]{1,4}[\s-]?[0-9]{1,4}$/", $_POST['phone'])) {
                $error['phone'] = "Le téléphone doit être un numéro valide.";
            }

            // Validation de la date de naissance
            if (!empty($_POST['birthdate'])) {
                try {
                    // Validation du format de la date de naissance
                    $birthdate = DateTime::createFromFormat('d/m/Y', $_POST['birthdate']);
                    
                    if (!$birthdate || $birthdate->format('d/m/Y') !== $_POST['birthdate']) {
                        $error['birthdate'] = "La date de naissance doit être au format JJ/MM/AAAA.";
                    } else {
                        // Convertir la date en format 'YYYY-MM-DD' pour la base de données
                        $user->setBirthdate($birthdate->format('Y-m-d'));
                    }
                } catch (Exception $e) {
                    $error['birthdate'] = "La date de naissance est invalide.";
                }
            }

            // Si des erreurs sont présentes, on les stocke dans la session et on redirige
            if (!empty($error)) {
                $_SESSION['errors'] = $error;
                $_SESSION['old_input'] = $_POST; // Garder les anciennes valeurs du formulaire
                header('Location: index.php?route=editProfile');
                exit;
            }

            // Si les validations sont passées, on récupère et met à jour les données de l'utilisateur
            $user->setFirstName($_POST['first_name']);
            $user->setLastName($_POST['last_name']);
            $user->setPhone($_POST['phone']);
            $user->setDescription($_POST['description']);
            
            // Traitement de l'image de profil (si une nouvelle image est téléchargée)
            if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'src/assets/img/';
                $uploadFile = $uploadDir . basename($_FILES['photo']['name']);
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                    $user->setPhoto($uploadFile);
                } else {
                    $_SESSION['errors']['photo'] = "Une erreur est survenue lors de l'upload de l'image.";
                }
            }

            // Mettre à jour l'utilisateur dans la base de données
            $repoUser->updateUser($user);

            // Vider les erreurs après le traitement
            unset($_SESSION['errors']);
            unset($_SESSION['old_input']);
            
            
            // Après avoir ajouté le projet avec succès
            $_SESSION['success_message'] = 'Vos données sont modifiés avec succès !';
            // Rediriger après la mise à jour
            header('Location: index.php?route=admin');
            exit;
        }


       
        // Afficher le formulaire avec les données actuelles de l'utilisateur
        $template = "profile/editProfile";
        require "src/views/layout.phtml";
    }
}
