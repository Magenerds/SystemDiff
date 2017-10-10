<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\DataWriter;

use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;

class DataWriterPool implements \IteratorAggregate
{
    /**
     * @var DataWriterInterface[] | TMap
     */
    private $dataWriter;

    /**
     * @param TMapFactory $tmapFactory
     * @param [] $dataWriters
     */
    public function __construct(
        TMapFactory $tmapFactory,
        array $dataWriters = []
    ) {
        $this->dataWriter = $tmapFactory->create(
            [
                'array' => $dataWriters,
                'type' => DataWriterInterface::class
            ]
        );
    }

    /**
     * Retrieves data writer by code
     *
     * @param string $dataWriterCode
     * @return DataWriterInterface
     * @throws NotFoundException
     */
    public function get($dataWriterCode)
    {
        if (!isset($this->dataWriter[$dataWriterCode])) {
            throw new NotFoundException(__('Data writer %1 does not exist.', $dataWriterCode));
        }

        return $this->dataWriter[$dataWriterCode];
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return \Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return $this->dataWriter;
    }
}