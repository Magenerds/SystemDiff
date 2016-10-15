<?php
/**
 * @copyright Copyright (c) 1999-2016 netz98 new media GmbH (http://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace Magenerds\SystemConfigDiff\Api\Service;

interface DiffDataServiceInterface
{
    /**
     * @param array $localData
     * @param array $remoteData
     */
    public function diffData(array $localData, array $remoteData);
}