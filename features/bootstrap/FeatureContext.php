<?php

use App\Entity\User;
use Behat\Behat\Context\Context;
use Behatch\Context\RestContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Symfony\Component\HttpKernel\KernelInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class FeatureContext
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class FeatureContext implements Context
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var RestContext
     */
    private $restContext;

    /**
     * @var JWTManager
     */
    private $jwtManager;

    /**
     * FeatureContext constructor.
     *
     * @param KernelInterface        $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->container = $kernel->getContainer();
        $this->jwtManager = $this->container->get('jwt_manager');
    }

    /**
     * @param BeforeScenarioScope $scope
     *
     * @BeforeScenario @loginAdmin
     */
    public function loginAdmin(BeforeScenarioScope $scope)
    {
        $user = new User();
        $user->setUsername('admin');

        $token = $this->jwtManager->create($user);

        $this->restContext = $scope->getEnvironment()->getContext(RestContext::class);
        $this->restContext->iAddHeaderEqualTo('Authorization', "Bearer $token");
    }

    /**
     * @param BeforeScenarioScope $scope
     *
     * @BeforeScenario @login
     */
    public function login(BeforeScenarioScope $scope)
    {
        $user = new User();
        $user->setUsername('reseller-0');

        $token = $this->jwtManager->create($user);

        $this->restContext = $scope->getEnvironment()->getContext(RestContext::class);
        $this->restContext->iAddHeaderEqualTo('Authorization', "Bearer $token");
    }

    /**
     * @logout
     */
    public function logout() {
        $this->restContext->iAddHeaderEqualTo('Authorization', '');
    }
}
