<?php

namespace App\Command;

use App\Imports\MasterImporter;
use App\Service\ImportService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import',
    description: 'Import data from Hubspot',
)]
class ImportCommand extends Command
{
    public function __construct(private readonly ImportService $importService, string $name = 'app:import')
    {
        parent::__construct($name);

    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->note('The import process may take a while, please be patient ...');

        $progress = new ProgressBar($output, count(MasterImporter::IMPORTERS));
        $progress->start();
        $callback = function () use ($progress) {
            $progress->advance();
        };

        $this->importService->import($callback);

        $io->success('Import process completed successfully Enjoy :D');

        return Command::SUCCESS;
    }
}
