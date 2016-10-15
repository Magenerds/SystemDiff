<?php

namespace Magenerds\SystemConfigDiff\Differ;

abstract class AbstractDiffer implements DifferInterface
{
    /**
     * Diffs two data sets of two systems.
     *
     * @param array $localData
     * @param array $remoteData
     * @return array
     */
    abstract function diff(array $localData, array $remoteData);

    /**
     * Does the diff of two arrays and returns the diff as array.
     *
     * @param array $arr1
     * @param array $arr2
     * @return array
     */
    protected function diffArrays(array $arr1, array $arr2)
    {
        $result = [];

        $result[1] = array_diff_assoc($arr1, $arr2);
        $result[2] = array_diff_assoc($arr2, $arr1);

        return $result;
    }
}