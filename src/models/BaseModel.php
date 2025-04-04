<?php

namespace App\models;

abstract class BaseModel {
    protected int $id;

    public function __construct(int $id = 0) {
        $this->id = $id;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
}
