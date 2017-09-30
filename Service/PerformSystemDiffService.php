<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Service;

use Magenerds\SystemDiff\Api\Service\FetchLocalDataServiceInterface;
use Magenerds\SystemDiff\Api\Service\FetchRemoteDataServiceInterface;
use Magenerds\SystemDiff\Api\Service\PerformSystemDiffServiceInterface;
use Magenerds\SystemDiff\Api\Service\SaveDiffToTableServiceInterface;

/**
 * Class PerformSystemDiffService
 * @package Magenerds\SystemDiff\Service
 */
class PerformSystemDiffService implements PerformSystemDiffServiceInterface
{
    /**
     * @var FetchLocalDataServiceInterface
     */
    protected $fetchLocalDataService;

    /**
     * @var FetchRemoteDataServiceInterface
     */
    protected $fetchRemoteDataService;

    /**
     * @var DiffDataService
     */
    protected $diffDataService;

    /**
     * @var SaveDiffToTableServiceInterface
     */
    private $saveDiffToTableService;

    /**
     * PerformSystemDiffService constructor.
     * @param FetchLocalDataServiceInterface $fetchLocalDataService
     * @param FetchRemoteDataServiceInterface $fetchRemoteDataService
     * @param DiffDataService $diffDataService
     * @param SaveDiffToTableServiceInterface $saveDiffToTableService
     */
    public function __construct(
        FetchLocalDataServiceInterface $fetchLocalDataService,
        FetchRemoteDataServiceInterface $fetchRemoteDataService,
        DiffDataService $diffDataService,
        SaveDiffToTableServiceInterface $saveDiffToTableService
    ) {
        $this->fetchLocalDataService = $fetchLocalDataService;
        $this->fetchRemoteDataService = $fetchRemoteDataService;
        $this->diffDataService = $diffDataService;
        $this->saveDiffToTableService = $saveDiffToTableService;
    }

    /**
     * Initiates the diff
     */
    public function performDiff()
    {
        $localData = $this->fetchLocalDataService->fetch();
        $remoteData = $this->fetchRemoteDataService->fetch();

        $diffData = $this->diffDataService->diffData($localData, $remoteData);

        $this->saveDiffToTableService->saveData($diffData);
    }
}