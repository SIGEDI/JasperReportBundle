<?php

namespace Sigedi\JasperReportBundle\Command;

use Sigedi\JasperReportBundle\ImportExportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportResourceCommand extends Command
{
    /**
     * @var ImportExportService
     */
    private $exportService;

    public function __construct(ImportExportService $importExportService)
    {
        $this->exportService = $importExportService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('jasper:export:resource')
            ->setDescription('Export Resource from Jasper-Server')
            ->addArgument('uri', InputArgument::REQUIRED, 'uri of resource')
            ->addArgument('filename', InputArgument::OPTIONAL, 'filename of output')
            ->addArgument('skipDependentResources', InputArgument::OPTIONAL,
                'skip dependent resources, e.g. database connection');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $uri = null;
        $filename = 'export';
        $skipDependentResources = false;

        if ($input->getArgument('uri') !== '') {
            $uri = $input->getArgument('uri');
        } else {
            return Command::FAILURE;
        }

        if ($input->getArgument('filename') !== '') {
            $filename = $input->getArgument('filename');
        }

        if ($input->getArgument('skipDependentResources') === 'true') {
            $skipDependentResources = true;
        }

        $this->exportService->exportResource($uri, $filename, $skipDependentResources, 2, false);

        return Command::SUCCESS;
    }
}
