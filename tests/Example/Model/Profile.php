<?php

declare(strict_types=1);

namespace KingsonDe\Marshal\Example\Model;

class Profile {

    /**
     * @var User
     */
    private $user;

    /**
     * @var User[]
     */
    private $followers;

    public function __construct(User $user, User ...$followers) {
        $this->user      = $user;
        $this->followers = $followers;
    }

    public function getUser(): User {
        return $this->user;
    }

    /**
     * @return User[]
     */
    public function getFollowers(): array {
        return $this->followers;
    }
}
