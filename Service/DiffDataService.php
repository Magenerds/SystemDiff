<?php
/**
 * @copyright Copyright (c) 1999-2016 netz98 new media GmbH (http://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace Magenerds\SystemConfigDiff\Service;

use Magenerds\SystemConfigDiff\Differ\DifferInterface;
use Magenerds\SystemConfigDiff\Differ\DifferPool;

class DiffDataService
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
     * @param array $localData
     * @param array $remoteData
     */
    public function diffData(array $localData, array $remoteData)
    {
        foreach ($this->differPool as $differCode => $differ) {
            /** @var DifferInterface $differ */
            $differ->diff($localData, $remoteData);
        }
    }
}