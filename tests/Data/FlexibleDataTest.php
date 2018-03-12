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
        unset($this->flexibleData['users'][1]);
        $this->flexibleData['users'][0]['username'] = 'pfefferkuchenmann';
        $this->flexibleData['userCount'] = 1;

        $this->assertSame('pfefferkuchenmann', $this->flexibleData['users'][0]['username']);
        $this->assertSame(1, $this->flexibleData['userCount']);
        $this->assertCount(1, $this->flexibleData['users']);
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
}
