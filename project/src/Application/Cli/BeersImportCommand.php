<?php

declare(strict_types=1);

namespace Application\Cli;

use Domain\Beer\Import\BeerImporter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class BeersImportCommand extends Command
{
    private const COUNT_MIN = 1;

    private const COUNT_MAX = 50;

    /**
     * @var BeerImporter
     */
    private $beerImporter;

    public function __construct(
        BeerImporter $beerImporter,
        string $name = 'beers:import'
    ) {
        parent::__construct($name);
        $this->beerImporter = $beerImporter;
    }

    public function configure()
    {
        parent::configure();

        $this->setDescription('Import beers from external service');
        $this->addArgument(
            'count',
            InputArgument::REQUIRED,
            'Number of beers to import'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = (int) $input->getArgument('count');

        if (
            $count < self::COUNT_MIN
            ||
            $count > self::COUNT_MAX
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

        $this->beerImporter->import($count);

        return 0;
    }
}
