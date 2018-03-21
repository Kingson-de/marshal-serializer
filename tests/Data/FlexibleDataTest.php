<?php

declare(strict_types = 1);

namespace KingsonDe\Marshal\Data;

use KingsonDe\Marshal\Example\Mapper\FollowerMapper;
use KingsonDe\Marshal\Example\Model\User;
use KingsonDe\Marshal\Marshal;
use PHPUnit\Framework\TestCase;

class FlexibleDataTest extends TestCase {

    /**
     * @var FlexibleData
     */
    private $flexibleData;

    protected function setUp() {
        $data = [
            'users' => [
                [
                    'username' => 'kingson',
                ],
                [
                    'username' => 'pfefferkuchenmann',
                ],
            ],
            'userCount' => 2,
        ];

        $this->flexibleData = new FlexibleData($data);
    }

    public function testArrayAccess() {
        unset($this->flexibleData['userCount'], $this->flexibleData['users'][1]);
        $this->flexibleData['users'][0]['username'] = 'pfefferkuchenmann';

        $this->assertSame('pfefferkuchenmann', $this->flexibleData['users'][0]['username']);
        $this->assertCount(1, $this->flexibleData['users']);
        $this->assertEmpty($this->flexibleData['userCount']);
    }

    public function testSerialize() {
        $user1 = new User(124, 'pfefferkuchenmann@example.org', 'pfefferkuchenmann');
        $user2 = new User(125, 'lululu@example.org', 'lululu');
        $user3 = new User(123, 'kingson@example.org', 'kingson');

        $this->flexibleData['users'] = new Collection(new FollowerMapper(), [$user1, $user2, $user3]);

        $data = Marshal::serialize($this->flexibleData);

        $this->assertSame('pfefferkuchenmann', $data['users'][0]['username']);
        $this->assertSame('lululu', $data['users'][1]['username']);
        $this->assertSame('kingson', $data['users'][2]['username']);
        $this->assertCount(3, $data['users']);
    }

    public function testGetMethod() {
        $this->flexibleData['custom'] = new \stdClass();

        $this->assertSame(2, $this->flexibleData->get('userCount'));
        $this->assertInstanceOf(FlexibleData::class, $this->flexibleData->get('users'));
        $this->assertInstanceOf(\stdClass::class, $this->flexibleData->get('custom'));
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testGetMethodWithInvalidKey() {
        $this->flexibleData->get('nothing');
    }

    public function testFindMethod() {
        $this->flexibleData['custom'] = new \stdClass();

        $this->assertSame(2, $this->flexibleData->find('userCount'));
        $this->assertInstanceOf(FlexibleData::class, $this->flexibleData->find('users'));
        $this->assertInstanceOf(\stdClass::class, $this->flexibleData->find('custom'));
    }

    public function testFindMethodWithInvalidKey() {
        $this->assertNull($this->flexibleData->find('nothing'));
        $this->assertSame(0, $this->flexibleData->find('nothing', 0));
    }

    public function testAddElement() {
        $this->flexibleData['users'][] = ['username' => 'lululu'];

        $this->assertCount(3, $this->flexibleData['users']);
        $this->assertSame('lululu', $this->flexibleData['users'][2]['username']);
    }

    public function testIterator() {
        $users = [];

        foreach ($this->flexibleData->get('users') as $key => $user) {
            $users[$key] = $user;
        }

        $this->assertSame('kingson', $users[0]['username']);
        $this->assertSame('pfefferkuchenmann', $users[1]['username']);
        $this->assertContainsOnlyInstancesOf(FlexibleData::class, $users);
    }
}
