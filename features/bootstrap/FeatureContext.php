<?php

use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Service\JwtService;
use Behat\Behat\Context\Context;
use Behatch\Context\RestContext;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManagerInterface;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Context\SnippetAcceptingContext;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class FeatureContext
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var KernelInterface
     */
    private $container;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var SchemaTool
     */
    private $schemaTool;

    /**
     * @var array
     */
    private $classes;

    /**
     * @var RestContext
     */
    private $restContext;

    /**
     * @var JwtService
     */
    private $jwtService;

    /**
     * FeatureContext constructor.
     *
     * @param ManagerRegistry $doctrine
     */
    public function __construct(KernelInterface $kernel, ManagerRegistry $doctrine, JwtService $jwtService)
    {
        $this->container = $kernel->getContainer();
        $this->doctrine = $doctrine;
        $this->jwtService = $jwtService;
        $this->manager = $doctrine->getManager();
        $this->schemaTool = new SchemaTool($this->manager);
        $this->classes = $this->manager->getMetadataFactory()->getAllMetadata();
    }

    /**
     * @BeforeScenario @createSchema
     */
    public function createDatabase()
    {
        $this->schemaTool->createSchema($this->classes);
    }

    /**
     * @AfterScenario @dropSchema
     */
    public function dropDatabase()
    {
        $this->schemaTool->dropSchema($this->classes);
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

        //$jwtManager = $this->container->get('lexik_jwt_authentication.jwt_manager');
        $token = $this->jwtService->create($user);

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
