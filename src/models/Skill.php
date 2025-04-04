<?php

namespace App\models;

class Skill extends BaseModel {
    private string $name;
    private int $level;
    private int $user_id;

    public function __construct(int $id, string $name, int $level, int $user_id) {
        parent::__construct($id);
        $this->name = $name;
        $this->level = $level;
        $this->user_id = $user_id;
    }

    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }

    public function getLevel(): int { return $this->level; }
    public function setLevel(int $level): void { $this->level = $level; }

    public function getUserId(): int { return $this->user_id; }
    public function setUserId(int $user_id): void { $this->user_id = $user_id; }
}
