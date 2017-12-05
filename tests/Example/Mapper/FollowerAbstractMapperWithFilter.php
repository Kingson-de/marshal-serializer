<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Example\Mapper;

use KingsonDe\Marshal\Example\Model\User;
use KingsonDe\Marshal\AbstractMapper;

class FollowerAbstractMapperWithFilter extends AbstractMapper {

    public function map(User $user) {
        if ($user->getUsername() === 'pfefferkuchenmann') {
            return null;
        }

        return [
            'username' => $user->getUsername(),
        ];
    }
}
