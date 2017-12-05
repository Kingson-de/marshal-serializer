<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Example\Mapper;

use KingsonDe\Marshal\Example\Model\User;
use KingsonDe\Marshal\AbstractMapper;

class FollowerAbstractMapper extends AbstractMapper {

    public function map(User $user) {
        return [
            'username' => $user->getUsername(),
        ];
    }
}
