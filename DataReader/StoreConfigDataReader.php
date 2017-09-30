<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\DataReader;

use Magento\Framework\App\Config\ConfigSourceInterface;

class StoreConfigDataReader implements DataReaderInterface
{
    /**
     * @var ConfigSourceInterface
     */
    private $configSource;

    /**
     * StoreConfigDataReader constructor.
     * @param ConfigSourceInterface $configSource
     */
    public function __construct(
        ConfigSourceInterface $configSource
    ){
        $this->configSource = $configSource;
    }

    /**
     * Reads the store configuration from database.
     *
     * @return array
     */
    public function read()
    {
        return $this->configSource->get();
    }
}