<?php

namespace App\Action;

use App\Entity\Client;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ClientPostAction
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class ClientPostAction
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * ClientPostAction constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Client $data
     *
     * @Route(
     *     name="api_client_post_collection_custom",
     *     path="/clients",
     *     methods={"POST"},
     *     defaults={"_api_resource_class"=Client::class, "_api_collection_operation_name"="post"}
     * )
     * @Method("POST")
     *
     * @return Client
     */
    public function __invoke(Client $data)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $data->setUser($user);

        return $data;
    }
}