<?php

use App\Entity\User;
use Behat\Behat\Context\Context;
use Behatch\Context\RestContext;
use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\ORM\EntityManagerInterface;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
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
     * @var EntityManagerInterface
     */
    private $manager;

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
        $this->manager = $this->container->get('doctrine.orm.default_entity_manager');
        $this->jwtManager = $this->container->get('jwt_manager');
    }

    /**
     * @BeforeScenario @fixtures
     */
    public function fixtures()
    {
        $userData = new UserFixtures();
        $userData->setContainer($this->container);

        $loader = new Loader();
        $loader->addFixture($userData);

        $purger = new ORMPurger();
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);

        $executor = new ORMExecutor($this->manager, $purger);
        $executor->execute($loader->getFixtures());
    }

    /**
     * @param BeforeScenarioScope $scope
     *
     * @BeforeScenario
     * @login
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
