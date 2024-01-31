# JasperReportBundle

**Requirements**

![Packagist PHP Version](https://img.shields.io/packagist/dependency-v/sigedi/jasper-report-bundle/php)
![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/sigedi/jasper-report-bundle/symfony/framework-bundle?label=symfony)
---

The JasperReportBundle requires jaspersoft/rest-client and provides an JasperReport-Client as service in the Symfony service container.

[Installation](#installation)<br>
[Basic Usage](#basic-usage-in-symfony)<br>
[Additional configuration options](#additional-configuration-options)<br>

## Installation

1 Add bundle to <code>composer.json</code>:
```shell
    composer require sigedi/jasper_report_bundle
```
2 The Bundle will be registred automatically and by executing the recipe the configuration 
file <code>jasper-report.yaml</code>
will be created in the <code>config/packages</code> directory and the corresponding entries
in the <code>.env</code> file will be made

3 Change the standard setting in the file <code>jasper-report.yaml</code>

```yaml
    sigedi_jasper_report:
        host:      'http://localhost:8080/jasperserver'
        username:  '%env(SIGEDI_JASPER_REPORT_USERNAME)%'
        password:  '%env(SIGEDI_JASPER_REPORT_PASSWORD)%'
        org_id:    '%env(SIGEDI_JASPER_REPORT_ORGID)%'
```

and in the <code>.env</code> file

```dotenv
SIGEDI_JASPER_REPORT_USERNAME=jasperadmin
SIGEDI_JASPER_REPORT_PASSWORD=jasperadmin
SIGEDI_JASPER_REPORT_ORGID=
```

## Basic Usage in Symfony

The bundle supports autowiring, so you can access the report-service directly in your controller, e.g.
```php
    use Symfony\Component\HttpFoundation\Request;
    use Sigedi\JasperReportBundleReportService;

    public function reportAction(Request $request, ReportService $reportService)
    {
        $report = $reportService->runReport('/reports/TestReport', 'pdf');

        $response = new Response($report);
        $response->headers->set('Content-type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=Report.pdf');
        $response->headers->set('Cache-Control', 'must-revalidate');

        return $response;
    }
```

## Additional Configuration Options

```yaml
    sigedi_jasper_report:
        host:      'http://localhost:8080/jasperserver'
        username:  '%env(SIGEDI_JASPER_REPORT_USERNAME)%'
        password:  '%env(SIGEDI_JASPER_REPORT_PASSWORD)%'
        org_id:    '%env(SIGEDI_JASPER_REPORT_ORGID)%'
        timeout:   50
```

**timeout:** timeout for REST-request (in seconds)