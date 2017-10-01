<?php

namespace Magenerds\SystemDiff\Remote;

use Magenerds\SystemDiff\Helper\Config;
use Magento\Framework\ObjectManager\ObjectManager;
use Magento\Framework\ObjectManagerInterface;

class ClientAdapter implements ClientInterface
{
    /**
     * @var ClientInterface
     */
    protected $subject;

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
     *
     * @param Config $configHelper
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(Config $configHelper, ObjectManagerInterface $objectManager)
    {
        $this->configHelper = $configHelper;
        $this->objectManager = $objectManager;
    }

    public function fetch()
    {
        if (null === $this->subject) {
            $this->subject = $this->objectManager->get($this->configHelper->getApiType());
        }

        return $this->subject->fetch();
    }
}