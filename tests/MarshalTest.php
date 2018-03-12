<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal;

use KingsonDe\Marshal\Data\Collection;
use KingsonDe\Marshal\Data\CollectionCallable;
use KingsonDe\Marshal\Data\FlexibleData;
use KingsonDe\Marshal\Data\Item;
use KingsonDe\Marshal\Data\ItemCallable;
use KingsonDe\Marshal\Example\ObjectMapper\ProfileObjectMapper;
use KingsonDe\Marshal\Example\Mapper\FollowerMapper;
use KingsonDe\Marshal\Example\Mapper\FollowerMapperWithFilter;
use KingsonDe\Marshal\Example\Mapper\ProfileMapper;
use KingsonDe\Marshal\Example\Mapper\ProfileMapperWithCallable;
use KingsonDe\Marshal\Example\Model\Profile;
use KingsonDe\Marshal\Example\Model\User;
use PHPUnit\Framework\TestCase;

class MarshalTest extends TestCase {

    public function testSerializeComplexObject() {
        $item = new Item(
            new ProfileMapper(),
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

        $equivalentData = Marshal::serializeItem(new ProfileMapper(), $this->createProfile());

        $this->assertSame($data, $equivalentData);
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

        $equivalentData = Marshal::serializeCollection(new FollowerMapper(), $this->createFollowers());

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

        $equivalentData = Marshal::serializeItem(new ProfileMapper(), $this->createProfile());

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

        $equivalentData = Marshal::serializeCollection(new FollowerMapper(), $this->createFollowers());

        $this->assertSame($data, $equivalentData);
    }

    public function testSerializeObjectWithCallableCombined() {
        $data = Marshal::serializeItem(new ProfileMapperWithCallable(), $this->createProfile());

        $this->assertSame(123, $data['id']);
        $this->assertSame('kingson@example.org', $data['email']);
        $this->assertSame('kingson', $data['username']);
        $this->assertSame(2, $data['follower_count']);
        $this->assertSame('pfefferkuchenmann', $data['followers'][0]['username']);
        $this->assertSame('lululu', $data['followers'][1]['username']);
        $this->assertNull($data['null']);

        $equivalentData = Marshal::serializeItem(new ProfileMapper(), $this->createProfile());

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

        $equivalentData = Marshal::serializeCollection(new FollowerMapperWithFilter(), $this->createFollowers());

        $this->assertSame($data, $equivalentData);
    }

    public function testDeserialize() {
        $data = Marshal::serializeItem(new ProfileMapper(), $this->createProfile());
        $flexibleData = new FlexibleData($data);

        /** @var Profile $profile */
        $profile = Marshal::deserialize(new ProfileObjectMapper(), $flexibleData);

        $this->assertSame(123, $profile->getUser()->getId());
        $this->assertSame('kingson@example.org', $profile->getUser()->getEmail());
        $this->assertSame('kingson', $profile->getUser()->getUsername());
        $this->assertEmpty($profile->getFollowers()[0]->getId());
        $this->assertEmpty($profile->getFollowers()[0]->getEmail());
        $this->assertSame('pfefferkuchenmann', $profile->getFollowers()[0]->getUsername());
        $this->assertEmpty($profile->getFollowers()[1]->getId());
        $this->assertEmpty($profile->getFollowers()[1]->getEmail());
        $this->assertSame('lululu', $profile->getFollowers()[1]->getUsername());
    }

    public function testDeserializeWithCallable() {
        $data = Marshal::serializeItem(new ProfileMapper(), $this->createProfile());
        $flexibleData = new FlexibleData($data);

        /** @var User $user */
        $user = Marshal::deserializeCallable(function (FlexibleData $flexibleData) {
            return new User(
                $flexibleData->get('id'),
                $flexibleData->get('email'),
                $flexibleData->get('username')
            );
        }, $flexibleData);

        $this->assertSame(123, $user->getId());
        $this->assertSame('kingson@example.org', $user->getEmail());
        $this->assertSame('kingson', $user->getUsername());
    }

    private function createProfile(): Profile {
        $user      = new User(123, 'kingson@example.org', 'kingson');
        $followers = $this->createFollowers();

        return new Profile($user, ...$followers);
    }

    private function createFollowers(): array {
        $follower1 = new User(124, 'pfefferkuchenmann@example.org', 'pfefferkuchenmann');
        $follower2 = new User(125, 'lululu@example.org', 'lululu');

        return [$follower1, $follower2];
    }
}
