<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\DataReader;

class StoreConfigDataReader implements DataReaderInterface
{
    /**
     * @var \Magento\Store\Model\Config\Reader\DefaultReader
     */
    private $defaultReader;
    /**
     * @var \Magento\Store\Model\Config\Reader\Website
     */
    private $websiteReader;
    /**
     * @var \Magento\Store\Model\Config\Reader\Store
     */
    private $storeReader;

    /**
     * StoreConfigDataReader constructor.
     * @param \Magento\Store\Model\Config\Reader\DefaultReader $defaultReader
     * @param \Magento\Store\Model\Config\Reader\Website $websiteReader
     * @param \Magento\Store\Model\Config\Reader\Store $storeReader
     */
    public function __construct
    (
        \Magento\Store\Model\Config\Reader\DefaultReader $defaultReader,
        \Magento\Store\Model\Config\Reader\Website $websiteReader,
        \Magento\Store\Model\Config\Reader\Store $storeReader
    ){
        $this->defaultReader = $defaultReader;
        $this->websiteReader = $websiteReader;
        $this->storeReader = $storeReader;
    }

    /**
     * Reads the store configuration from database.
     *
     * @return array
     */
    public function read()
    {
        return [
            'default' => $this->defaultReader->read(),
            'websites' => $this->websiteReader->read(),
            'stores' => $this->storeReader->read()
        ];
    }
}