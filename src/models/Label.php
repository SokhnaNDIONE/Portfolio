<?php

namespace App\models;

class Label extends BaseModel {
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
}
