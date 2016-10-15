<?php

namespace Magenerds\SystemConfigDiff\Differ;

interface DifferInterface
{
    /**
     * @param array $localData
     * @param array $remoteData
     * @return array
     */
    public function diff(array $localData, array $remoteData);
}