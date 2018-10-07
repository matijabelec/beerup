<?php

namespace Tests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractIntegrationTest extends KernelTestCase
{
    /**
     * @var Application
     */
    protected $application;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $this->application = new Application($kernel);

        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->application = null;
    }
}
