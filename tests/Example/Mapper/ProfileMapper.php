<?php

declare(strict_types=1);

namespace KingsonDe\ResponseMapper\Example\Mapper;

use KingsonDe\ResponseMapper\Example\Model\Profile;
use KingsonDe\ResponseMapper\Mapper;

class ProfileMapper extends Mapper {

    public function map(Profile $profile) {
        $user      = $profile->getUser();
        $followers = $profile->getFollowers();

        return [
            'id'             => $user->getId(),
            'email'          => $user->getEmail(),
            'username'       => $user->getUsername(),
            'follower_count' => count($followers),
            'followers'      => $this->collection(new FollowerMapper(), $followers),
            'null'           => $this->object(new NullMapper()),
        ];
    }
}
