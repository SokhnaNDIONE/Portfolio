<?php

namespace App\models;

class User {

    private int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private string $description;
    private string $photo;
    private string $birthdate;
    private int $phone;

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getPhoto(): string {
        return $this->photo;
    }

    public function getPhone(): int {
        return $this->phone;
    }

    public function getBirthdate(): string {
        return $this->birthdate;
    }

    // Setters
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setPhoto(string $photo): void {
        $this->photo = $photo;
    }

    public function setPhone(int $phone): void {
        $this->phone = $phone;
    }

    public function setBirthdate(string $birthdate): void {
        $this->birthdate = $birthdate;
    }

    // Fonction pour assainir les données
    public function sanitize(array $userData): self {
        $this->id = $userData['id'];
        $this->firstName = $userData['first_name'];
        $this->lastName = $userData['last_name'];
        $this->email = $userData['email'];
        $this->password = $userData['password']; // Si le mot de passe est déjà hashé
        $this->description = $userData['description'];
        $this->photo = $userData['photo'];
        $this->birthdate = $userData['birthdate'];
        $this->phone = $userData['phone'];

        return $this;
    }
}
