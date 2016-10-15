<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemConfigDiff\DataReader;

use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;
use Traversable;

class DataReaderPool implements \IteratorAggregate
{
    /**
     * @var DataReaderInterface[] | TMap
     */
    private $dataReader;

    /**
     * @param TMapFactory $tmapFactory
     * @param array $dataReader
     */
    public function __construct(
        TMapFactory $tmapFactory,
        array $dataReader = []
    ) {
        $this->dataReader = $tmapFactory->create(
            [
                'array' => $dataReader,
                'type' => DataReaderInterface::class
            ]
        );
    }

    /**
     * Retrieves data reader by code
     *
     * @param string $dataReaderCode
     * @return DataReaderInterface
     * @throws NotFoundException
     */
    public function get($dataReaderCode)
    {
        if (!isset($this->dataReader[$dataReaderCode])) {
            throw new NotFoundException(__('Data reader %1 does not exist.', $dataReaderCode));
        }

        return $this->dataReader[$dataReaderCode];
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return $this->dataReader;
    }
}