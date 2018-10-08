<?php

namespace Beer\Import;

use Domain\Beer\Import\ExternalBeerNotFoundException;
use Exception;
use Infrastructure\Request\FakeClient;
use Prophecy\Argument;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\AbstractIntegrationTest;

class BeersImportTest extends AbstractIntegrationTest
{
    /**
     * @dataProvider numberOfBeersProvider
     */
    public function testWillFailOnInvalidArgumentPassed(int $numberOfBeers)
    {
        $clientMock = $this->prophesize(FakeClient::class);
        $clientMock->get(Argument::any())->willReturn('');

        $this->application->getKernel()
            ->getContainer()
            ->set(FakeClient::class, $clientMock->reveal());

        $command = $this->application->find('beers:import');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
            'number-of-beers' => $numberOfBeers,
        ]);

        $this->assertEquals(1, $commandTester->getStatusCode());
        $this->assertContains('Number of beers to import must be in range', $commandTester->getDisplay());
    }


    public function testCreateAds()
    {
        $jsonResponse = file_get_contents(sprintf('%s/../../DataFixture/PunkApiBeers.json', __DIR__));

        $clientMock = $this->prophesize(FakeClient::class);
        $clientMock->get(Argument::any())->willReturn($jsonResponse);

        $this->application->getKernel()
            ->getContainer()
            ->set(FakeClient::class, $clientMock->reveal());

        $command = $this->application->find('beers:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'number-of-beers' => 3,
        ]);

        $this->assertEquals(0, $commandTester->getStatusCode());
    }

    public function testIgnoreDoubles()
    {
        $jsonResponse = file_get_contents(sprintf('%s/../../DataFixture/PunkApiBeers.json', __DIR__));

        $clientMock = $this->prophesize(FakeClient::class);
        $clientMock->get(Argument::any())->willReturn($jsonResponse);

        $this->application->getKernel()
            ->getContainer()
            ->set(FakeClient::class, $clientMock->reveal());

        $command = $this->application->find('beers:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'number-of-beers' => 3,
        ]);

        $this->assertEquals(0, $commandTester->getStatusCode());

        $command = $this->application->find('beers:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'number-of-beers' => 3,
        ]);

        $this->assertEquals(0, $commandTester->getStatusCode());
    }

    public function testWillFailIfExternalServiceIsNotAvailable()
    {
        $clientMock = $this->prophesize(FakeClient::class);
        $clientMock->get(Argument::any())->willThrow(Exception::class);

        $this->application->getKernel()
            ->getContainer()
            ->set(FakeClient::class, $clientMock->reveal());

        $this->expectException(ExternalBeerNotFoundException::class);

        $command = $this->application->find('beers:import');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'number-of-beers' => 3,
        ]);
    }

    public function numberOfBeersProvider()
    {
        return [
            [ 0, ],
            [ 100, ],
        ];
    }
}
