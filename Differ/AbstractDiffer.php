<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Differ;

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