<?php

namespace Magenerds\SystemConfigDiff\Differ;

class StoreConfigDiffer implements DifferInterface
{
    /**
     * @param array $localData
     * @param array $remoteData
     * @return array
     */
    public function diff(array $localData, array $remoteData)
    {
        return [];
    }
}