<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Example\Model;

class User {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    public function __construct(int $id, string $email, string $username) {
        $this->id       = $id;
        $this->email    = $email;
        $this->username = $username;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getUsername(): string {
        return $this->username;
    }
}
