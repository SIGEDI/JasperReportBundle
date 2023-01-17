<?php

namespace Sigedi\JasperReportBundle;

use Jaspersoft\Client\Client;

class Factory
{
    /**
     * @var Client
     */
    private $reportClient;

    /**
     * @var ReportService
     */
    private $reportService;

    /**
     * @var ImportExportService
     */
    private $importExportService;

    /**
     * @var RepositoryService
     */
    private $repositoryService;

    public function createClient($config): void
    {
        $server_url = $config['host'];
        $username = $config['username'];
        $password = $config['password'];
        $org_id = $config['org_id'];

        $this->reportClient = new Client($server_url, $username, $password, $org_id);

        if (isset($config['timeout'])) {
            $timeout = intval($config['timeout']);
            if (is_numeric($config['timeout']) && $timeout > 0) {
                $this->reportClient->setRequestTimeout($timeout);
            }
        }
    }

    public function getClient(): Client
    {
        return $this->reportClient;
    }

    /**
     * get report-service.
     */
    public function getReportService(): ReportService
    {
        if (!isset($this->reportService)) {
            $this->reportService = new ReportService($this->reportClient->reportService());
        }

        return $this->reportService;
    }

    /**
     * get export-/import-service.
     */
    public function getImportExportService(): ImportExportService
    {
        if (!isset($this->importExportService)) {
            $this->importExportService = new ImportExportService($this->reportClient->importExportService());
        }

        return $this->importExportService;
    }

    /**
     * get repository service.
     */
    public function getRepositoryService(): RepositoryService
    {
        if (!isset($this->repositoryService)) {
            $this->repositoryService = new RepositoryService($this->reportClient->repositoryService());
        }

        return $this->repositoryService;
    }
}
