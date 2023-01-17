<?php

namespace Sigedi\JasperReportBundle;

use Jaspersoft\Dto\Resource\File;
use Jaspersoft\Dto\Resource\Resource;
use Jaspersoft\Service\Criteria\RepositorySearchCriteria;
use Jaspersoft\Service\Result\SearchResourcesResult;

class RepositoryService
{
    /**
     * @var \Jaspersoft\Service\RepositoryService
     */
    private $jaserRepositoryService;

    /**
     * RepositoryService constructor.
     */
    public function __construct(\Jaspersoft\Service\RepositoryService $repositoryService)
    {
        $this->jaserRepositoryService = $repositoryService;
    }

    /**
     * Search repository by criteria.
     */
    public function searchResources(RepositorySearchCriteria $criteria = null): SearchResourcesResult
    {
        return $this->jaserRepositoryService->searchResources($criteria);
    }

    /**
     * Get resource by URI.
     *
     * @param bool $expanded Return sub resources as definitions and not references?
     */
    public function getResource(string $uri, bool $expanded = false): Resource
    {
        return $this->jaserRepositoryService->getResource($uri, $expanded);
    }

    /**
     * Obtain the raw binary data of a file resource stored on the server (e.x: image).
     */
    public function getBinaryFileData(File $file): string
    {
        return $this->jaserRepositoryService->getBinaryFileData($file);
    }

    /**
     * Create a resource.
     *
     * Note: Resources can be placed at arbitrary locations, or in a folder. Thus, you must set EITHER $parentFolder
     * OR the uri parameter of the Resource used in the first argument.
     *
     * @param resource    $resource      Resource object fully describing new resource
     * @param string|null $parentFolder  folder in which the resource should be created
     * @param bool        $createFolders Create folders in the path that may not exist?
     *
     *@throws \Exception
     */
    public function createResource(Resource $resource, string $parentFolder = null, bool $createFolders = true): Resource
    {
        return $this->jaserRepositoryService->createResource($resource, $parentFolder, $createFolders);
    }

    /**
     * Update a resource.
     *
     * @param resource $resource  Resource object fully describing updated resource
     * @param bool     $overwrite Replace existing resource even if type differs?
     */
    public function updateResource(Resource $resource, bool $overwrite = false): Resource
    {
        return $this->jaserRepositoryService->updateResource($resource, $overwrite);
    }

    /**
     * Update a file on the server by supplying binary data.
     *
     * @param File   $resource   A resource descriptor for the File
     * @param string $binaryData The binary data of the file to update
     */
    public function updateFileResource(File $resource, string $binaryData): Resource
    {
        return $this->jaserRepositoryService->updateFileResource($resource, $binaryData);
    }
}
