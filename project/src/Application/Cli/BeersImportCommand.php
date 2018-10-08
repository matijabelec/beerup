<?php

declare(strict_types=1);

namespace Application\Cli;

use Domain\Beer\Service\ImportBeerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class BeersImportCommand extends Command
{
    private const COUNT_MIN = 1;

    private const COUNT_MAX = 50;

    /**
     * @var ImportBeerService
     */
    private $importBeerService;

    public function __construct(
        ImportBeerService $importBeerService,
        string $name = 'beers:import'
    ) {
        parent::__construct($name);
        $this->importBeerService = $importBeerService;
    }

    public function configure()
    {
        parent::configure();

        $this->setDescription('Import beers from external service');
        $this->addArgument(
            'number-of-beers',
            InputArgument::REQUIRED,
            'Number of beers to import'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $numberOfBeers = (int) $input->getArgument('number-of-beers');

        if (
            $numberOfBeers < self::COUNT_MIN
            ||
            $numberOfBeers > self::COUNT_MAX
        ) {
            $output->writeln(
                sprintf(
                    '<error>Number of beers to import must be in range %d - %d</error>',
                    self::COUNT_MIN,
                    self::COUNT_MAX
                )
            );
            return 1;
        }

        $this->importBeerService->import($numberOfBeers);

        return 0;
    }
}
