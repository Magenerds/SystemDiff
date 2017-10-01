<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Model;

use Magenerds\SystemDiff\Api\Data\ConfigDataInterface;

class ConfigData implements ConfigDataInterface
{
    /**
     * @var []
     */
    private $data;

    /**
     * ConfigData constructor.
     *
     * @param [] $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @inheritdoc
     * @return mixed|[]
     */
    public function getData()
    {
        return [$this->data];
    }
}