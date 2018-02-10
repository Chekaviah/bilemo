<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class UserFixtures
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class UserFixtures extends Fixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@website.net');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($passwordEncoder->encodePassword($admin, 'admin'));
        $admin->setActive(true);
        $manager->persist($admin);

        $user = new User();
        $user->setUsername('user');
        $user->setEmail('user@website.net');
        $user->setPassword($passwordEncoder->encodePassword($user, 'user'));
        $user->setActive(true);
        $manager->persist($user);

        $clients = $this->getClients();

        foreach ($this->getUsers() as $u) {
            $reseller = new User();
            $reseller->setUsername($u[1]);
            $reseller->setEmail($u[2]);
            $reseller->setPassword($passwordEncoder->encodePassword($reseller, 'user'));
            $reseller->setActive(true);
            $manager->persist($reseller);

            for ($i=$u[0]; $i<100; $i+=10) {
                $client = new Client();
                $client->setName($clients[$i][0]);
                $client->setEmail($clients[$i][1]);
                $client->setAddress($clients[$i][2]);
                $client->setUser($reseller);

                $manager->persist($client);
            }
        }

        $manager->flush();
    }

    private function getUsers(): array
    {
        $users = [];
        for ($i=0; $i<10; $i++) {
            $users[] = [
                $i,
                'reseller-'.$i,
                'reseller'.$i.'@website.net'
            ];
        }

        return $users;
    }

    private function getClients(): array
    {
        $clients = [];
        for ($i=1; $i<=100; $i++) {
            $clients[] = [
                'client-'.$i,
                'client'.$i.'@website.net',
                $i.' rue de l\'infini',
            ];
        }

        return $clients;
    }
}
