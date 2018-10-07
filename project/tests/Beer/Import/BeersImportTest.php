<?php

namespace Beer\Import;

use Domain\Beer\Import\Exception\ExternalBeersWasNotReadable;
use Exception;
use Infrastructure\Request\CurlClient;
use Prophecy\Argument;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\AbstractIntegrationTest;

class BeersImportTest extends AbstractIntegrationTest
{
    /**
     * @dataProvider countProvider
     */
    public function testWillFailOnInvalidArgumentPassed(int $count)
    {
        $clientMock = $this->prophesize(CurlClient::class);
        $clientMock->get(Argument::any())->willReturn('');

        $this->application->getKernel()
            ->getContainer()
            ->set(CurlClient::class, $clientMock->reveal());

        $command = $this->application->find('beers:import');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
            'count' => $count,
        ]);

        $this->assertEquals(1, $commandTester->getStatusCode());
        $this->assertContains('Number of beers to import must be in range', $commandTester->getDisplay());
    }


    public function testCreateAds()
    {
        $jsonResponse = file_get_contents(sprintf('%s/../../DataFixture/PunkApiBeers.json', __DIR__));

        $clientMock = $this->prophesize(CurlClient::class);
        $clientMock->get(Argument::any())->willReturn($jsonResponse);

        $this->application->getKernel()
            ->getContainer()
            ->set(CurlClient::class, $clientMock->reveal());

        $command = $this->application->find('beers:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'count' => 3,
        ]);

        $this->assertEquals(0, $commandTester->getStatusCode());
    }

    public function testIgnoreDoubles()
    {
        $jsonResponse = file_get_contents(sprintf('%s/../../DataFixture/PunkApiBeers.json', __DIR__));

        $clientMock = $this->prophesize(CurlClient::class);
        $clientMock->get(Argument::any())->willReturn($jsonResponse);

        $this->application->getKernel()
            ->getContainer()
            ->set(CurlClient::class, $clientMock->reveal());

        $command = $this->application->find('beers:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'count' => 3,
        ]);

        $this->assertEquals(0, $commandTester->getStatusCode());

        $command = $this->application->find('beers:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'count' => 3,
        ]);

        $this->assertEquals(0, $commandTester->getStatusCode());
    }

    public function testWillFailIfExternalServiceIsNotAvailable()
    {
        $clientMock = $this->prophesize(CurlClient::class);
        $clientMock->get(Argument::any())->willThrow(Exception::class);

        $this->application->getKernel()
            ->getContainer()
            ->set(CurlClient::class, $clientMock->reveal());

        $this->expectException(ExternalBeersWasNotReadable::class);

        $command = $this->application->find('beers:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'count' => 3,
        ]);
    }

    public function countProvider()
    {
        return [
            [ 0, ],
            [ 100, ],
        ];
    }
}
