<?php

declare(strict_types=1);

namespace Sigedi\JasperReportBundle;

use Jaspersoft\Client\Client;

class Factory
{
    private Client $reportClient;

    private ReportService $reportService;

    public function createClient($config): void
    {
        $server_url = $config['host'];
        $username = $config['username'];
        $password = $config['password'];
        $org_id = $config['org_id'];

        $this->reportClient = new Client($server_url, $username, $password, $org_id);

        if (isset($config['timeout'])) {
            $timeout = (int) $config['timeout'];
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
}
