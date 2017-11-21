<?php

declare(strict_types=1);

namespace KingsonDe\Marshal;

use KingsonDe\Marshal\Data\Collection;
use KingsonDe\Marshal\Data\Object;
use KingsonDe\Marshal\Example\Mapper\FollowerMapper;
use KingsonDe\Marshal\Example\Mapper\ProfileMapper;
use KingsonDe\Marshal\Example\Model\Profile;
use KingsonDe\Marshal\Example\Model\User;
use PHPUnit\Framework\TestCase;

class MarshalTest extends TestCase {

    public function testSerializeComplexObject() {
        $profile = $this->createProfile();

        $object = new Object(
            new ProfileMapper(),
            $profile
        );

        $data = Marshal::serialize($object);

        $this->assertSame(123, $data['id']);
        $this->assertSame('kingson@example.org', $data['email']);
        $this->assertSame('kingson', $data['username']);
        $this->assertSame(2, $data['follower_count']);
        $this->assertSame('pfefferkuchenmann', $data['followers'][0]['username']);
        $this->assertSame('lululu', $data['followers'][1]['username']);
        $this->assertNull($data['null']);
    }

    public function testSerializeCollection() {
        $collection = new Collection(
            new FollowerMapper(),
            $this->createFollowers()
        );

        $data = Marshal::serialize($collection);

        $this->assertCount(2, $data);
        $this->assertSame('pfefferkuchenmann', $data[0]['username']);
        $this->assertSame('lululu', $data[1]['username']);
    }

    private function createProfile(): Profile {
        $user      = new User(123, 'kingson@example.org', 'kingson');
        $followers = $this->createFollowers();

        return new Profile($user, ...$followers);
    }

    private function createFollowers() {
        $follower1 = new User(124, 'pfefferkuchenmann@example.org', 'pfefferkuchenmann');
        $follower2 = new User(125, 'lululu@example.org', 'lululu');

        return [$follower1, $follower2];
    }
}
