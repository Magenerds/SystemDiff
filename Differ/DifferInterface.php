<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Differ;

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