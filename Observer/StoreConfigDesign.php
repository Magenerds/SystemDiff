<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\Asset\GroupedCollection;
use Magenerds\SystemDiff\Helper\Config;

class StoreConfigDesign implements ObserverInterface
{
    /**
     * @var Repository
     */
    private $assetRepository;

    /**
     * @var GroupedCollection
     */
    private $assetCollection;

    /**
     * @var Config
     */
    private $config;

    /**
     * Design constructor.
     * @param Repository $assetRepository
     * @param GroupedCollection $assetCollection
     * @param Config $config
     */
    public function __construct(
        Repository $assetRepository,
        GroupedCollection $assetCollection,
        Config $config
    ){
        $this->assetRepository = $assetRepository;
        $this->assetCollection = $assetCollection;
        $this->config = $config;
    }

    /**
     * Adds custom design css if diff displaying is enabled
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->config->isDisplayStoreConfig()) {
            $asset = $this->assetRepository->createAsset('Magenerds_SystemDiff::css/style.css');
            $this->assetCollection->add('magenerds_systemdiff', $asset);
        }
    }
}