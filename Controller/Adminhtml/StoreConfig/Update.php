<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Controller\Adminhtml\StoreConfig;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Magenerds\SystemDiff\Helper\StoreConfigUpdater;
use Magento\Framework\Controller\Result\Json;

class Update extends Action
{
    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var StoreConfigUpdater
     */
    private $storeConfigUpdater;

    /**
     * Update constructor.
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param StoreConfigUpdater $storeConfigUpdater
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        StoreConfigUpdater $storeConfigUpdater
    ) {
        parent::__construct($context);

        $this->jsonFactory = $jsonFactory;
        $this->storeConfigUpdater = $storeConfigUpdater;
    }

    /**
     * Updates store configuration
     *
     * @return Json
     */
    public function execute()
    {
        /** @var $result Json */
        $result = $this->jsonFactory->create();

        if (!$params = $this->getParams()) {
            $result->setHttpResponseCode(400);
            return $result->setData(['errors' => true, 'message' => 'Missing parameters']);
        }

        if ($this->getRequest()->isAjax()) {
            $this->storeConfigUpdater->updateStoreConfig($params['path'], $params['scope'], $params['scopeId']);
            $result->setHttpResponseCode(200);
            return $result->setData([]);
        }
    }

    /**
     * @return []|bool
     */
    protected function getParams()
    {
        $params = $this->getRequest()->getParams();

        if (!array_key_exists('path', $params)
            || !array_key_exists('scope', $params)
            || !array_key_exists('scopeId', $params))
        {
            return false;
        }

        return [
            'path' => $params['path'],
            'scope' => $params['scope'],
            'scopeId' => $params['scopeId']
        ];
    }

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenerds_SystemDiff::store_config_update');
    }
}