<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Helper;

use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magenerds\SystemDiff\Model\ResourceModel\DiffConfig\Collection;
use Magenerds\SystemDiff\Model\ResourceModel\DiffConfig\CollectionFactory;
use Magenerds\SystemDiff\Model\DiffConfig;
use Magenerds\SystemDiff\Model\ResourceModel\DiffConfig as DiffConfigResource;
use Magenerds\SystemDiff\Model\ResourceModel\DiffConfigFactory as DiffConfigResourceFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\Store;

class StoreConfigUpdater
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var DiffConfigResourceFactory
     */
    private $diffConfigResourceFactory;

    /**
     * Config constructor.
     * @param ConfigInterface $config
     * @param CollectionFactory $collectionFactory
     * @param DiffConfigResourceFactory $diffConfigResourceFactory
     */
    public function __construct(
        ConfigInterface $config,
        CollectionFactory $collectionFactory,
        DiffConfigResourceFactory $diffConfigResourceFactory
    ) {
        $this->config = $config;
        $this->collectionFactory = $collectionFactory;
        $this->diffConfigResourceFactory = $diffConfigResourceFactory;
    }

    /**
     * Updates the local store configuration with the remote value
     *
     * @param $path
     * @param $scope
     * @param $scopeId
     * @return bool
     */
    public function updateStoreConfig($path, $scope, $scopeId)
    {
        /** @var $collection Collection */
        $collection = $this->collectionFactory->create();

        $collection->addFieldToFilter('path', $path);
        $collection->addFieldToFilter('scope', $scope);
        $collection->addFieldToFilter('scope_id', $scopeId);

        if ($collection->count() === 0) {
            return false;
        }

        /** @var $entry DiffConfig */
        $entry = $collection->getFirstItem();
        $value = $entry->getDiffValueRemote();
        $this->saveStoreConfig($path, $value, $scope, $scopeId);

        /** @var $diffConfigResource DiffConfigResource */
        $diffConfigResource = $this->diffConfigResourceFactory->create();
        $diffConfigResource->delete($entry);
    }

    /**
     * Save given store configuration
     *
     * @param $path
     * @param $value
     * @param string $scope
     * @param int $scopeId
     */
    public function saveStoreConfig($path, $value, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = Store::DEFAULT_STORE_ID)
    {
        $this->config->saveConfig($path, $value, $scope, $scopeId);
    }
}