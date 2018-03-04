<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class UserTest extends TestCase
{
    public function testAttributes()
    {
        $clientStub = $this->createMock(Client::class);
        $clientStub->method('getId')
            ->willReturn(0);

        $client2Stub = $this->createMock(Client::class);

        $user = new User();
        $user->setUsername('username');
        $user->setPlainPassword('plainpassword');
        $user->setPassword('password');
        $user->setEmail('user@website.net');
        $user->setActive(true);
        $user->addClient($clientStub);
        $user->addClient($client2Stub);

        $serialize = $user->serialize();

        static::assertNull($user->getId());
        static::assertTrue($user->getActive());
        static::assertTrue($user->isEnabled());
        static::assertNull($user->getSalt());
        static::assertNull($user->eraseCredentials());
        static::assertGreaterThan(0, strlen($serialize));
        static::assertNull($user->unserialize($serialize));
        static::assertEquals('username', $user->getUsername());
        static::assertEquals('plainpassword', $user->getPlainPassword());
        static::assertEquals('password', $user->getPassword());
        static::assertEquals('user@website.net', $user->getEmail());
        static::assertEquals(['ROLE_USER'], $user->getRoles());
        static::assertEquals(0, $user->getClients()->offsetGet(0)->getId());
        static::assertEquals(2, $user->getClients()->count());

        $user->setRoles(['ROLE_ADMIN']);
        $user->removeClient($client2Stub);

        static::assertEquals(['ROLE_ADMIN'], $user->getRoles());
        static::assertEquals(1, $user->getClients()->count());
    }
}
