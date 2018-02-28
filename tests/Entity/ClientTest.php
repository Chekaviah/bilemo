<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class ClientTest extends TestCase
{
    public function testAttributes()
    {
        $userStub = $this->createMock(User::class);

        $client = new Client();
        $client->setName('name');
        $client->setEmail('client@website.net');
        $client->setAddress('address');
        $client->setUser($userStub);

        static::assertNull($client->getId());
        static::assertEquals('name', $client->getName());
        static::assertEquals('client@website.net', $client->getEmail());
        static::assertEquals('address', $client->getAddress());
        static::assertInstanceOf(User::class, $client->getUser());
    }
}
