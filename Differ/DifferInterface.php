<?php

namespace Magenerds\SystemConfigDiff\Differ;

interface DifferInterface
{
    /**
     * Diffs two data sets of two systems.
     *
     * @param array $localData
     * @param array $remoteData
     * @return array
     */
    public function diff(array $localData, array $remoteData);
}