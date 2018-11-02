<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Example\ObjectMapper;

use KingsonDe\Marshal\AbstractObjectMapper;
use KingsonDe\Marshal\Data\FlexibleData;
use KingsonDe\Marshal\Example\Model\User;

class UserObjectMapper extends AbstractObjectMapper {

    /**
     * @inheritdoc
     *
     * @return User
     */
    public function map(FlexibleData $flexibleData, ...$additionalData) {
        return new User(
            $flexibleData['id'] ?? 0,
            $flexibleData['email'] ?? '',
            $flexibleData->find('username', '')
        );
    }
}
