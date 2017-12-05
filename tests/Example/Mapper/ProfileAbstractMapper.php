<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Example\Mapper;

use KingsonDe\Marshal\Example\Model\Profile;
use KingsonDe\Marshal\AbstractMapper;

class ProfileAbstractMapper extends AbstractMapper {

    public function map(Profile $profile) {
        $user      = $profile->getUser();
        $followers = $profile->getFollowers();

        return [
            'id'             => $user->getId(),
            'email'          => $user->getEmail(),
            'username'       => $user->getUsername(),
            'follower_count' => \count($followers),
            'followers'      => $this->collection(new FollowerAbstractMapper(), $followers),
            'null'           => $this->item(new NullAbstractMapper()),
        ];
    }
}
