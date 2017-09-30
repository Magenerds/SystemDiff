<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Cron;

use Magenerds\SystemDiff\Service\PerformSystemDiffService;

/**
 * Class Diff
 * @package Magenerds\SystemDiff\Cron
 */
class Diff
{
    /**
     * @var PerformSystemDiffService
     */
    private $performSystemDiffService;

    /**
     * Diff constructor.
     * @param PerformSystemDiffService $performSystemDiffService
     */
    public function __construct(
        PerformSystemDiffService $performSystemDiffService
    ){
        $this->performSystemDiffService = $performSystemDiffService;
    }

    /**
     * @return $this
     */
    public function execute()
    {
        $this->performSystemDiffService->performDiff();
        return $this;
    }
}