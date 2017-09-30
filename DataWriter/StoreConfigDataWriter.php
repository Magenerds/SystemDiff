<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\DataWriter;

use Magenerds\SystemDiff\Model\DiffConfig as DiffConfigModel;
use Magenerds\SystemDiff\Model\DiffConfigFactory;
use Magenerds\SystemDiff\Model\ResourceModel\DiffConfig as DiffConfigResource;
use Magento\Store\Model\StoreManagerInterface;

class StoreConfigDataWriter implements DataWriterInterface
{
    const LOCAL_VALUE_FIELD_NAME = 'diff_value_local';
    const REMOTE_VALUE_FIELD_NAME = 'diff_value_remote';

    const SCOPE_FIELD_NAME = 'scope';
    const SCOPE_ID_FIELD_NAME = 'scope_id';
    const PATH_FIELD_NAME = 'path';
    const SCOPE_VALUE_WEBSITES = 'websites';
    const SCOPE_VALUE_STORES = 'stores';

    const DEFAULT_SCOPE_ID = 0;
    const ARRAY_INDEX_LOCAL = 1;
    const ARRAY_INDEX_REMOTE = self::EXPECTED_SPLITTED_PATH_LENGTH;
    const ARRAY_STORE_CONFIG_KEY = 'storeConfig';
    const SCOPE_KEYS = ['default', 'websites', 'stores'];
    const EXPECTED_SPLITTED_PATH_LENGTH = 2;

    /**
     * @var DiffConfigResource
     */
    private $diffConfigResource;
    /**
     * @var DiffConfigFactory
     */
    private $diffConfigFactory;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * StoreConfigDataWriter constructor.
     * @param DiffConfigResource $diffConfigResource
     * @param DiffConfigFactory $diffConfigFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        DiffConfigResource $diffConfigResource,
        DiffConfigFactory $diffConfigFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->diffConfigResource = $diffConfigResource;
        $this->diffConfigFactory = $diffConfigFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @param array $diffData
     * @return void
     */
    public function write(array $diffData)
    {
        if (empty($diffData) || !array_key_exists(self::ARRAY_STORE_CONFIG_KEY, $diffData)) {
            return;
        }

        $diffData = $diffData[self::ARRAY_STORE_CONFIG_KEY];

        foreach ($diffData as $scope => $data) {
            if (!in_array($scope, self::SCOPE_KEYS)) {
                continue;
            }

            if (!array_key_exists(self::ARRAY_INDEX_LOCAL, $data)
                || !array_key_exists(self::ARRAY_INDEX_REMOTE, $data)
            ) {
                continue;
            }

            $localValues = $data[self::ARRAY_INDEX_LOCAL];
            $remoteValues = $data[self::ARRAY_INDEX_REMOTE];

            $localModels = $this->mapDataToModels($localValues, $scope, self::LOCAL_VALUE_FIELD_NAME);
            $remoteModels = $this->mapDataToModels($remoteValues, $scope, self::REMOTE_VALUE_FIELD_NAME);

            $scopeModels = array_merge($localModels, $remoteModels);

            foreach ($scopeModels as $scopeModel) {
                $this->diffConfigResource->save($scopeModel);
            }
        }
    }

    /**
     * @param array $data
     * @param string $scope
     * @param string $valueField
     *
     * @return DiffConfigModel[]
     */
    protected function mapDataToModels(array $data, $scope, $valueField)
    {
        $models = [];

        foreach ($data as $path => $value) {
            /** @var DiffConfigModel $diffConfigModel */
            $diffConfigModel = $this->diffConfigFactory->create();
            $diffConfigModel->setData(self::SCOPE_FIELD_NAME, $scope);

            $scopeId = self::DEFAULT_SCOPE_ID;

            if ($scope === self::SCOPE_VALUE_WEBSITES || $scope === self::SCOPE_VALUE_STORES) {
                if (empty($path)) {
                    continue;
                }

                $splittedPath = explode('/', $path, self::EXPECTED_SPLITTED_PATH_LENGTH);

                if (count($splittedPath) !== self::EXPECTED_SPLITTED_PATH_LENGTH) {
                    continue;
                }

                $code = $splittedPath[0];
                $path = $splittedPath[1];

                if ($scope === self::SCOPE_VALUE_WEBSITES) {
                    $scopeId = $this->getWebsiteId($code);
                }

                if ($scope === self::SCOPE_VALUE_STORES) {
                    $scopeId = $this->getStoreId($code);
                }
            }

            $diffConfigModel->setData(self::SCOPE_ID_FIELD_NAME, $scopeId);
            $diffConfigModel->setData(self::PATH_FIELD_NAME, $path);
            $diffConfigModel->setData($valueField, $value);

            $models[] = $diffConfigModel;
        }

        return $models;
    }

    /**
     * @param string $code
     * @return int
     */
    private function getWebsiteId($code): int
    {
        return $this->storeManager->getWebsite($code)->getId();
    }

    /**
     * @param string $code
     * @return int
     */
    private function getStoreId($code): int
    {
        return $this->storeManager->getStore($code)->getId();
    }

}