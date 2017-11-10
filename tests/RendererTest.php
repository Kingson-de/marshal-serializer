<?php

declare(strict_types=1);

namespace KingsonDe\ResponseMapper;

use KingsonDe\ResponseMapper\Data\Object;
use KingsonDe\ResponseMapper\Example\Mapper\ProfileMapper;
use KingsonDe\ResponseMapper\Example\Model\Profile;
use KingsonDe\ResponseMapper\Example\Model\User;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase {

    public function testRenderingObject() {
        $profile = $this->createProfile();

        $object = new Object(
            new ProfileMapper(),
            $profile
        );

        $data = Renderer::createData($object);

        $this->assertSame(123, $data['id']);
        $this->assertSame('kingson@example.org', $data['email']);
        $this->assertSame('kingson', $data['username']);
        $this->assertSame(2, $data['follower_count']);
        $this->assertSame('pfefferkuchenmann', $data['followers'][0]['username']);
        $this->assertSame('lululu', $data['followers'][1]['username']);
        $this->assertNull($data['null']);
    }

    private function createProfile(): Profile {
        $user      = new User(123, 'kingson@example.org', 'kingson');
        $follower1 = new User(124, 'pfefferkuchenmann@example.org', 'pfefferkuchenmann');
        $follower2 = new User(125, 'lululu@example.org', 'lululu');

        return new Profile($user, ...[$follower1, $follower2]);
    }
}
