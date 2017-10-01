<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Differ;

use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;
use Traversable;

class DifferPool implements \IteratorAggregate
{
    /**
     * @var DifferInterface[] | TMap
     */
    private $differs;

    /**
     * @param TMapFactory $tmapFactory
     * @param [] $differs
     */
    public function __construct(
        TMapFactory $tmapFactory,
        array $differs = []
    ) {
        $this->differs = $tmapFactory->create(
            [
                'array' => $differs,
                'type' => DifferInterface::class
            ]
        );
    }

    /**
     * Retrieves differ by code
     *
     * @param string $differCode
     * @return DifferInterface
     * @throws NotFoundException
     */
    public function get($differCode)
    {
        if (!isset($this->differs[$differCode])) {
            throw new NotFoundException(__('Differ %1 does not exist.', $differCode));
        }

        return $this->differs[$differCode];
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
        return $this->differs;
    }
}