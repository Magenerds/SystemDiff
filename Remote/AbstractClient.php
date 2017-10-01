<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Remote;

use Magenerds\SystemDiff\Helper\Config;

class AbstractClient
{
    /**
     * @var Config
     */
    private $helper;

    /**
     * Client constructor.
     *
     * @param Config $configHelper
     */
    public function __construct(Config $configHelper)
    {
        $this->helper = $configHelper;
    }

    /**
     * @param $json
     * @return []
     */
    protected function buildDataFromJson($json)
    {
        $responseData = json_decode($json, true);
        if (is_array($responseData)) {
            return $responseData;
        }

        return [];
    }
}