<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Model\ResourceModel\DiffConfig;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenerds\SystemDiff\Model\DiffConfig;
use Magenerds\SystemDiff\Model\ResourceModel\DiffConfig as DiffConfigResource;

/**
 * Class Collection
 * @package Magenerds\SystemDiff\Model\ResourceModel\DiffConfig
 */
class Collection extends AbstractCollection
{
    /**
     *  Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(DiffConfig::class,
            DiffConfigResource::class
        );
    }
}