<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Example\ObjectMapper;

use KingsonDe\Marshal\AbstractObjectMapper;
use KingsonDe\Marshal\Data\FlexibleData;
use KingsonDe\Marshal\Example\Model\Profile;

class ProfileObjectMapper extends AbstractObjectMapper {

    /**
     * @inheritdoc
     *
     * @return Profile
     */
    public function map(FlexibleData $flexibleData) {
        $userMapper = new UserObjectMapper();

        return new Profile(
            $this->item($userMapper, $flexibleData),
            ...$this->collection($userMapper, $flexibleData->get('followers'))
        );
    }
}
