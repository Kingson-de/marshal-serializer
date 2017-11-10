<?php

declare(strict_types=1);

namespace KingsonDe\ResponseMapper\Example\Mapper;

use KingsonDe\ResponseMapper\Example\Model\User;
use KingsonDe\ResponseMapper\Mapper;

class FollowerMapper extends Mapper {

    public function map(User $user) {
        return [
            'username' => $user->getUsername(),
        ];
    }
}
