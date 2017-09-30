<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class to read module-specific configuration
 *
 * Class Config
 * @package Magenerds\SystemDiff\Helper
 */
class Config
{
    /**
     * Holds the configuration paths for this module
     */
    const XML_PATH_ENABLED = 'system_diff/general/enabled';
    const XML_PATH_REMOTE_SYSTEM_URL = 'system_diff/connection/remote_system_url';
    const XML_PATH_ACCESS_TOKEN = 'system_diff/connection/access_token';
    const XML_PATH_API_TYPE = 'system_diff/connection/api_type';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED);
    }

    /**
     * @return string|null
     */
    public function getRemoteSystemUrl()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_REMOTE_SYSTEM_URL);
    }

    /**
     * Returns the class/type name to use as Client.
     *
     * @return string|null
     */
    public function getApiType()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_API_TYPE);
    }

    /**
     * @return string|null
     */
    public function getRemoteSystemAccessToken()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ACCESS_TOKEN);
    }
}