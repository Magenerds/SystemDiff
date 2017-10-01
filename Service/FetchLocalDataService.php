<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Service;

use Magenerds\SystemDiff\Api\Service\FetchLocalDataServiceInterface;
use Magenerds\SystemDiff\DataReader\DataReaderPool;
use Magenerds\SystemDiff\DataReader\DataReaderInterface;
use Magenerds\SystemDiff\Api\Data\ConfigDataInterface;
use Magenerds\SystemDiff\Api\Data\ConfigDataInterfaceFactory;

class FetchLocalDataService implements FetchLocalDataServiceInterface
{
    /**
     * @var DataReaderPool
     */
    private $dataReaderPool;

    /**
     * @var ConfigDataInterfaceFactory
     */
    private $configDataFactory;

    /**
     * FetchLocalDataService constructor.
     * @param DataReaderPool $dataReaderPool
     * @param ConfigDataInterfaceFactory $configDataFactory
     */
    public function __construct(
        DataReaderPool $dataReaderPool,
        ConfigDataInterfaceFactory $configDataFactory
    ){
        $this->dataReaderPool = $dataReaderPool;
        $this->configDataFactory = $configDataFactory;
    }

    /**
     * @return ConfigDataInterface
     */
    public function fetch()
    {
        $data = [];

        foreach ($this->dataReaderPool as $dataReaderCode => $dataReader) {
            /** @var DataReaderInterface $dataReader */
            $data[$dataReaderCode] = $dataReader->read();
        }

        return $this->configDataFactory->create(['data' => $data]);
    }
}