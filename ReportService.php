<?php

namespace Sigedi\JasperReportBundle;

class ReportService
{
    /**
     * @var \Jaspersoft\Service\ReportService
     */
    private $jaserReportService;

    /**
     * ReportService constructor.
     */
    public function __construct(\Jaspersoft\Service\ReportService $reportService)
    {
        $this->jaserReportService = $reportService;
    }

    /**
     * This function runs and retrieves the binary data of a report.
     *
     * @param string      $uri               URI for the report you wish to run
     * @param string      $format            The format you wish to receive the report in (default: pdf)
     * @param string|null $pages             Request a specific page, or range of pages. Separate multiple pages or ranges by commas.
     *                                       (e.g: "1,4-22,42,55-100")
     * @param string|null $attachmentsPrefix a URI to prefix all image attachment sources with
     *                                       (must include trailing slash if needed)
     * @param array|null  $inputControls     associative array of key => value for any input controls
     * @param bool        $interactive       Should report using Highcharts be interactive?
     * @param bool        $onePagePerSheet   Produce paginated XLS or XLSX?
     * @param string|null $transformerKey    For use when running a report as a JasperPrint. Specifies print element transformers
     *
     * @return string Binary data of report
     */
    public function runReport(
        string $uri,
        string $format = 'pdf',
        string $pages = null,
        string $attachmentsPrefix = null,
        array $inputControls = null,
        bool $interactive = true,
        bool $onePagePerSheet = false,
        bool $freshData = true,
        bool $saveDataSnapshot = false,
        string $transformerKey = null
    ): string {
        return $this->jaserReportService->runReport(
            $uri, $format, $pages, $attachmentsPrefix, $inputControls,
            $interactive, $onePagePerSheet, $freshData, $saveDataSnapshot, $transformerKey
        );
    }

    /**
     * This function will request the possible values and data behind all the input controls of a report.
     */
    public function getReportInputControls(string $uri): array
    {
        return $this->jaserReportService->getReportInputControls($uri);
    }
}
