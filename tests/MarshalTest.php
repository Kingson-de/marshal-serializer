<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal;

use KingsonDe\Marshal\Data\Collection;
use KingsonDe\Marshal\Data\CollectionCallable;
use KingsonDe\Marshal\Data\Item;
use KingsonDe\Marshal\Data\ItemCallable;
use KingsonDe\Marshal\Example\Mapper\FollowerAbstractMapper;
use KingsonDe\Marshal\Example\Mapper\FollowerAbstractMapperWithFilter;
use KingsonDe\Marshal\Example\Mapper\ProfileAbstractMapper;
use KingsonDe\Marshal\Example\Mapper\ProfileAbstractMapperWithCallable;
use KingsonDe\Marshal\Example\Model\Profile;
use KingsonDe\Marshal\Example\Model\User;
use PHPUnit\Framework\TestCase;

class MarshalTest extends TestCase {

    public function testSerializeComplexObject() {
        $item = new Item(
            new ProfileAbstractMapper(),
            $this->createProfile()
        );

        $data = Marshal::serialize($item);

        $this->assertSame(123, $data['id']);
        $this->assertSame('kingson@example.org', $data['email']);
        $this->assertSame('kingson', $data['username']);
        $this->assertSame(2, $data['follower_count']);
        $this->assertSame('pfefferkuchenmann', $data['followers'][0]['username']);
        $this->assertSame('lululu', $data['followers'][1]['username']);
        $this->assertNull($data['null']);

        $equivalentData = Marshal::serializeItem(new ProfileAbstractMapper(), $this->createProfile());

        $this->assertSame($data, $equivalentData);
    }

    public function testSerializeCollection() {
        $collection = new Collection(
            new FollowerAbstractMapper(),
            $this->createFollowers()
        );

        $data = Marshal::serialize($collection);

        $this->assertCount(2, $data);
        $this->assertSame('pfefferkuchenmann', $data[0]['username']);
        $this->assertSame('lululu', $data[1]['username']);

        $equivalentData = Marshal::serializeCollection(new FollowerAbstractMapper(), $this->createFollowers());

        $this->assertSame($data, $equivalentData);
    }

    public function testSerializeComplexObjectWithCallable() {
        $data = Marshal::serializeItemCallable(function (Profile $profile) {
            $user      = $profile->getUser();
            $followers = $profile->getFollowers();

            return [
                'id'             => $user->getId(),
                'email'          => $user->getEmail(),
                'username'       => $user->getUsername(),
                'follower_count' => \count($followers),
                'followers'      => new CollectionCallable(function (User $user) {
                    return [
                        'username' => $user->getUsername(),
                    ];
                }, $followers),
                'null' => new ItemCallable(function () {
                    return null;
                }),
            ];
        }, $this->createProfile());

        $this->assertSame(123, $data['id']);
        $this->assertSame('kingson@example.org', $data['email']);
        $this->assertSame('kingson', $data['username']);
        $this->assertSame(2, $data['follower_count']);
        $this->assertSame('pfefferkuchenmann', $data['followers'][0]['username']);
        $this->assertSame('lululu', $data['followers'][1]['username']);
        $this->assertNull($data['null']);

        $equivalentData = Marshal::serializeItem(new ProfileAbstractMapper(), $this->createProfile());

        $this->assertSame($data, $equivalentData);
    }

    public function testSerializeCollectionWithCallable() {
        $data = Marshal::serializeCollectionCallable(function (User $user) {
            return [
                'username' => $user->getUsername(),
            ];
        }, $this->createFollowers());

        $this->assertCount(2, $data);
        $this->assertSame('pfefferkuchenmann', $data[0]['username']);
        $this->assertSame('lululu', $data[1]['username']);

        $equivalentData = Marshal::serializeCollection(new FollowerAbstractMapper(), $this->createFollowers());

        $this->assertSame($data, $equivalentData);
    }

    public function testSerializeObjectWithCallableCombined() {
        $data = Marshal::serializeItem(new ProfileAbstractMapperWithCallable(), $this->createProfile());

        $this->assertSame(123, $data['id']);
        $this->assertSame('kingson@example.org', $data['email']);
        $this->assertSame('kingson', $data['username']);
        $this->assertSame(2, $data['follower_count']);
        $this->assertSame('pfefferkuchenmann', $data['followers'][0]['username']);
        $this->assertSame('lululu', $data['followers'][1]['username']);
        $this->assertNull($data['null']);

        $equivalentData = Marshal::serializeItem(new ProfileAbstractMapper(), $this->createProfile());

        $this->assertSame($data, $equivalentData);
    }

    public function testCollectionFilterOutNullRows() {
        $data = Marshal::serializeCollectionCallable(function (User $user) {
            if ($user->getUsername() === 'pfefferkuchenmann') {
                return null;
            }

            return [
                'username' => $user->getUsername(),
            ];
        }, $this->createFollowers());

        $this->assertCount(1, $data);
        $this->assertSame('lululu', $data[0]['username']);

        $equivalentData = Marshal::serializeCollection(new FollowerAbstractMapperWithFilter(), $this->createFollowers());

        $this->assertSame($data, $equivalentData);
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
