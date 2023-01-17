<?php

namespace Sigedi\JasperReportBundle;

use Jaspersoft\Dto\ImportExport\ExportTask;
use Jaspersoft\Dto\ImportExport\ImportTask;
use Jaspersoft\Dto\ImportExport\TaskState;

class ImportExportService
{
    /**
     * @var \Jaspersoft\Service\ReportService
     */
    private $jasperImportExportService;

    /**
     * ImportExportService constructor.
     */
    public function __construct(\Jaspersoft\Service\ImportExportService $importExportService)
    {
        $this->jasperImportExportService = $importExportService;
    }

    /**
     * Begin an export task.
     */
    public function startExportTask(ExportTask $exportTask): TaskState
    {
        return $this->jasperImportExportService->startExportTask($exportTask);
    }

    /**
     * Retrieve the state of your export request.
     *
     * @param int|string $id task ID
     */
    public function getExportState($id): TaskState
    {
        return $this->getExportState($id);
    }

    /**
     * Begin an import task.
     *
     * @param string $file_data Raw binary data of import zip
     */
    public function startImportTask(ImportTask $importTask, string $file_data): TaskState
    {
        return $this->jasperImportExportService->startImportTask($importTask, $file_data);
    }

    /**
     * Obtain the state of an ongoing import task.
     *
     * @param int|string $id
     */
    public function getImportState($id): TaskState
    {
        return $this->jasperImportExportService->getImportState($id);
    }

    /**
     * export resource from jasper server.
     */
    public function exportResource(
        $uri, string $filename = 'export',
        bool $skipDependentResources = false,
        int $refreshSec = 3, $silent = true
    ): void {
        $exportTask = new ExportTask();

        $exportTask->uris[] = $uri;

        if ($skipDependentResources) {
            $exportTask->parameters[] = 'skip-dependent-resources';
        }

        /** @var TaskState $taskState */
        $taskState = $this->jasperImportExportService->startExportTask($exportTask);

        if (!$silent) {
            echo $taskState->message."\n";
        }

        $decline = true;
        while ($decline) {
            $taskState = $this->jasperImportExportService->getExportState($taskState->id);
            if ($taskState->phase === 'finished') {
                if (!$silent) {
                    echo $taskState->message."\n";
                }
                $decline = false;
            } else {
                sleep($refreshSec);
            }
        }

        $exportFilename = $filename;
        $ext = pathinfo($exportFilename, PATHINFO_EXTENSION);

        if ($ext !== 'zip') {
            $exportFilename .= '.zip';
        }

        $f = fopen($exportFilename, 'w');
        $data = $this->jasperImportExportService->fetchExport($taskState->id);
        fwrite($f, $data);
        fclose($f);
    }

    /**
     * import resource from file to jasper server.
     */
    public function importResource(
        string $filename = 'export',
        bool $includeBrokenDependencies = false,
        int $refreshSec = 3,
        $silent = true
    ): void {
        $importTask = new ImportTask();

        $importTask->update = true;
        $importTask->includeAccessEvents = false;
        $importTask->includeAuditEvents = false;
        $importTask->includeMonitoringEvents = false;
        $importTask->includeServerSettings = false;

        if ($includeBrokenDependencies) {
            $importTask->brokenDependencies = 'include';
        }

        $taskState = $this->jasperImportExportService->startImportTask($importTask, file_get_contents($filename));

        if (!$silent) {
            echo $taskState->message."\n";
        }

        $decline = true;
        while ($decline) {
            $taskState = $this->jasperImportExportService->getImportState($taskState->id);
            if ($taskState->phase === 'finished') {
                if (!$silent) {
                    echo $taskState->message."\n";
                }
                $decline = false;
            } else {
                sleep($refreshSec);
            }
        }
    }
}
