<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Model;

use Magento\Framework\Model\AbstractModel;
use Magenerds\SystemDiff\Model\ResourceModel\DiffConfig as DiffConfigResource;

/**
 * Class DiffConfig
 * @method getDiffValueRemote()
 * @package Magenerds\SystemDiff\Model
 */
class DiffConfig extends AbstractModel
{
    /**
     * Initialize resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(DiffConfigResource::class);
    }
}