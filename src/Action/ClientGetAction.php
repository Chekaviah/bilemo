<?php

namespace App\Action;

use App\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ClientGetAction
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class ClientGetAction
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * ClientGetAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Paginator                     $data
     * @param Request                       $request
     * @param AuthorizationCheckerInterface $authorizationChecker
     *
     * @Route(
     *     name="api_client_get_collection_custom",
     *     path="/api/clients",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=Client::class, "_api_collection_operation_name"="get"}
     * )
     * @Method("GET")
     *
     * @return Paginator
     */
    public function __invoke(Paginator $data, Request $request, AuthorizationCheckerInterface $authorizationChecker)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $userId = $request->query->getInt('user');

        if (false === $authorizationChecker->isGranted('ROLE_ADMIN') && $user->getId() !== $userId)
            throw new AccessDeniedException('You can only see your own clients');

        return $data;
    }
}