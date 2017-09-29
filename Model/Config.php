<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Model;

/**
 * Class to read module-specific configuration
 *
 * Class Config
 * @package Magenerds\SystemDiff\Model
 */
class Config
{
    const XML_PATH_ENABLED = 'system_diff/general/enabled';
    const XML_PATH_REMOTE_SYSTEM_URL = 'system_diff/connection/remote_system_url';
    const XML_PATH_ACCESS_TOKEN = 'system_diff/connection/access_token';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $config;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $config
    ) {
        $this->config = $config;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->config->isSetFlag(self::XML_PATH_ENABLED);
    }

    /**
     * @return string|null
     */
    public function getRemoteSystemUrl()
    {
        return $this->config->getValue(self::XML_PATH_REMOTE_SYSTEM_URL);
    }

    /**
     * @return string|null
     */
    public function getRemoteSystemAccessToken()
    {
        return $this->config->getValue(self::XML_PATH_ACCESS_TOKEN);
    }
}