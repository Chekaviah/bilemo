<?php

namespace App\Service;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class JwtService
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class JwtService
{
    /**
     * @var JWTTokenManagerInterface
     */
    private $jwtManager;

    /**
     * JwtService constructor.
     *
     * @param JWTTokenManagerInterface $jwtManager
     */
    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    /**
     * @param UserInterface $user
     *
     * @return string
     */
    public function create(UserInterface $user)
    {
        return $this->jwtManager->create($user);
    }
}
