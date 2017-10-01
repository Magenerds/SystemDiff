<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Service;

use Magenerds\SystemDiff\Api\Service\DiffDataServiceInterface;
use Magenerds\SystemDiff\Differ\DifferInterface;
use Magenerds\SystemDiff\Differ\DifferPool;

class DiffDataService implements DiffDataServiceInterface
{
    /**
     * @var DifferPool
     */
    private $differPool;

    /**
     * DiffDataService constructor.
     * @param DifferPool $differPool
     */
    public function __construct(DifferPool $differPool)
    {
        $this->differPool = $differPool;
    }

    /**
     * @param [] $localData
     * @param [] $remoteData
     * @return []
     */
    public function diffData(array $localData, array $remoteData)
    {
        $differences = [];

        foreach ($this->differPool as $differCode => $differ) {
            /** @var DifferInterface $differ */
            $differences[$differCode] = $differ->diff((array)$localData, (array)$remoteData);
        }

        return $differences;
    }
}