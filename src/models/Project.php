<?php
namespace App\models;

class Project extends BaseModel {
    private string $title;
    private string $image;
    private string $description;
    private int $categoryId;  
    private int $userId; 

    public function __construct(int $id, string $title, string $image, string $description, int $categoryId, int $userId) {
        parent::__construct($id);
        $this->title = $title;
        $this->image = $image;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->userId = $userId;  
    }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): void { $this->title = $title; }

    public function getImage(): string { return $this->image; }
    public function setImage(string $image): void { $this->image = $image; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }

    public function getCategoryId(): int { return $this->categoryId; }
    public function setCategoryId(int $categoryId): void { $this->categoryId = $categoryId; }

    public function getUserId(): int { return $this->userId; }  
    public function setUserId(int $userId): void { $this->userId = $userId; }  
    
}
