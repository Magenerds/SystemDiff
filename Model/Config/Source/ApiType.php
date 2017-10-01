<?php

namespace Magenerds\SystemDiff\Model\Config\Source;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Option\ArrayInterface;

/**
 * Option source for Api Type to choose.
 */
class ApiType implements ArrayInterface
{
    /**
     * Holds the configuration key for api types
     */
    const XML_PATH_TYPES = 'system/magenerds/system_diff/api_types';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * ApiType constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Options getter
     *
     * @return []
     */
    public function toOptionArray()
    {
        $options = [];

        $types = $this->getConfiguredOptions();

        foreach ($types as $label => $type) {
            $options[] = ['value' => $type, 'label' => $label];
        }

        return $options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return []
     */
    public function toArray()
    {
        $options = [];

        $types = $this->getConfiguredOptions();

        foreach ($types as $label => $type) {
            $options[$type] = $label;
        }

        return $options;
    }

    /**
     * Returns the options configured in config path 'system/magenerds/system_diff/api_types'.
     *
     * This is the place to extend the config with additional types.
     *
     * @return []
     */
    protected function getConfiguredOptions(): array
    {
        $types = $this->scopeConfig->getValue(self::XML_PATH_TYPES);

        if (is_array($types)) {
            return $types;
        }

        return [];
    }
}
