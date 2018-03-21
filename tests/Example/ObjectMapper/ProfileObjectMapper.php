<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Example\ObjectMapper;

use KingsonDe\Marshal\AbstractObjectMapper;
use KingsonDe\Marshal\Data\FlexibleData;
use KingsonDe\Marshal\Example\Model\Profile;

class ProfileObjectMapper extends AbstractObjectMapper {

    public function map(FlexibleData $flexibleData, ...$additionalData): Profile {
        $userMapper = new UserObjectMapper();

        $includeFollowers = array_shift($additionalData) ?? true;
        $followers = $includeFollowers
            ? $this->collection($userMapper, $flexibleData->get('followers'))
            : [];

        return new Profile(
            $this->item($userMapper, $flexibleData),
            ...$followers
        );
    }
}
