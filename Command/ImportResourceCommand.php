<?php

namespace Sigedi\JasperReportBundle\Command;

use Sigedi\JasperReportBundle\ImportExportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportResourceCommand extends Command
{
    /**
     * @var ImportExportService
     */
    private $importService;

    public function __construct(ImportExportService $importExportService)
    {
        $this->importService = $importExportService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('jasper:import:resource')
            ->setDescription('Import Resource from Jasper-Server')
            ->addArgument('filename', InputArgument::REQUIRED, 'filename')
            ->addArgument('includeBrokenDependencies', InputArgument::OPTIONAL,
                'include broken dependencies');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = null;
        $includeBrokenDependencies = false;

        if ($input->getArgument('filename') !== '') {
            $filename = $input->getArgument('filename');
        } else {
            return Command::FAILURE;
        }

        if ($input->getArgument('includeBrokenDependencies') === 'true') {
            $includeBrokenDependencies = true;
        }

        $this->importService->importResource($filename, $includeBrokenDependencies, 2, false);

        return Command::SUCCESS;
    }
}
