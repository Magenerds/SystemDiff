<?php

namespace Magenerds\SystemDiff\Remote;

use Magenerds\SystemDiff\Helper\Config;
use Magento\Framework\ObjectManager\ObjectManager;
use Magento\Framework\ObjectManagerInterface;

class ClientAdapter implements ClientAdapterInterface
{
    /**
     * @var Config
     */
    private $configHelper;
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * ClientAdapter constructor.
     * @param Config $configHelper
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(Config $configHelper, ObjectManagerInterface $objectManager)
    {
        $this->configHelper = $configHelper;
        $this->objectManager = $objectManager;
    }

    public function getClient() : ClientInterface {
        return $this->objectManager->get($this->configHelper->getApiType());
    }
}