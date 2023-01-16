<?php

namespace Hboie\JasperReportBundle;

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

    public function createClient($config)
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

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->reportClient;
    }

    /**
     * get report-service.
     *
     * @return \Hboie\JasperReportBundle\ReportService
     */
    public function getReportService()
    {
        if (!isset($this->reportService)) {
            $this->reportService = new ReportService($this->reportClient->reportService());
        }

        return $this->reportService;
    }

    /**
     * get export-/import-service.
     *
     * @return \Hboie\JasperReportBundle\ImportExportService
     */
    public function getImportExportService()
    {
        if (!isset($this->importExportService)) {
            $this->importExportService = new ImportExportService($this->reportClient->importExportService());
        }

        return $this->importExportService;
    }

    /**
     * get repository service.
     *
     * @return \Hboie\JasperReportBundle\RepositoryService
     */
    public function getRepositoryService()
    {
        if (!isset($this->repositoryService)) {
            $this->repositoryService = new RepositoryService($this->reportClient->repositoryService());
        }

        return $this->repositoryService;
    }
}
