# JasperReportBundle

**Requirements**

![Packagist PHP Version](https://img.shields.io/packagist/dependency-v/sigedi/jasper-report-bundle/php)
![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/sigedi/jasper-report-bundle/symfony/framework-bundle?label=symfony)
---

The JasperReportBundle requires jaspersoft/rest-client and provides an JasperReport-Client as service in the Symfony service container.

[Installation](#installation)<br>
[Basic Usage](#basic-usage-in-symfony)<br>
[Search Resource Command](#search-resource-command)<br>
[Export Resource Command](#export-resource-command)<br>
[Import Resource Command](#import-resource-command)<br>
[Copying Resources between different servers](#copying-resources-between-different-servers)<br>
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

## Search Resource Command

With the <code>jasper:repository:search</code> you can search resources on the JaserReport server

```shell
    php bin/console jasper:repository:search <Citeria> <Detail>
```

**Criteria:** search criteria<br>
**Detail:** show details (optional)<br>
If no detail-value is given, only the uri of the resources will be listed. If an detail value greater 
than 0 is given, full data will be displayed.
 
## Export Resource Command

With the <code>jasper:export:resource</code> command, a given resource will be exported 
from the JasperServer and downloaded to an zip-archive file.

```shell
    php bin/console jasper:export:resource <UriOfResource> <Filename> <SkipDependentResources>
```

**UriOfResource:** uri of the resouce that should be downloaded<br>
**Filename:** filename of the local target file<br>
**SkipDependentResources:** if set to "true", dependent resource, e.g. the database 
connection of a report will be skipped.<br>

## Import Resource Command

With the <code>jasper:import:resource</code> command, a previously exported resource 
can be imported to a JasperServer.

```shell
    php bin/console jasper:import:resource <Filename> <includeBrokenDependencies>
```

**Filename:** filename of the local import file<br>
**includeBrokenDependencies:** if set to "true", for resources with broken dependencies
(e.g. exported with the option <code>SkipDependentResources</code>) the import process
attempts to import the resource by resolving dependencies with local resources.<br>

## Copying Resources between different Servers

You can use the export and import resources commands to copy resources from 
one server to another, e.g. between different stages of
an application. Use the <code>SkipDependentResources</code> option when exporting a 
resource and the <code>includeBrokenDependencies</code> option when importing it 
on the second server to avoid that the database connection is overwritten on 
the target server.

Take care that the export and import keys on both servers are adjusted. 
Read https://community.jaspersoft.com/documentation/tibco-jasperreports-server-security-guide/v7/using-custom-keys
for further information on how to use customs keys.

Create key store

```shell
    keytool -genseckey -keystore ./mystore -storetype jceks -storepass <storepass> -keyalg AES -keysize 128 -alias importExportEncSecret -keypass <keypass>
```

Copy store to JasperServer's buildomatic directory

```shell
    cp ./mystore /opt/jasperreports-server-cp-7.8.0/buildomatic/
```

Go to the buildomatic directory as root user and import key to JasperServer

```shell
    ./js-import.sh --input-key --keystore ./mystore --storepass <storepass> --keyalias importExportEncSecret --keypass <keypass>
```

Restart the JasperServer application or reboot the server

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