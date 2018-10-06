<?php

namespace Tests;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\DataFixture\BeerFixture;

abstract class AbstractFunctionalTest extends WebTestCase
{
    /**
     * @var EntityManager
     */
    protected $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $loader = new Loader();
        $loader->addFixture(new BeerFixture());

        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());

        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->em = null;
    }
}
