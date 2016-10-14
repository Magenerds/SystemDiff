<?php

namespace Magenerds\SystemConfigDiff\Api;

interface DifferInterface
{
    /**
     * @param array $thisData
     * @param array $otherData
     * @return array
     */
    public function diff($thisData, $otherData);
}