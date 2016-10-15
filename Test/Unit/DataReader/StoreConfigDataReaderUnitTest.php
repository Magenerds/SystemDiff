<?php

namespace Magenerds\SystemConfigDiff\Test\Unit\DataReader;


class StoreConfigDataReaderUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magenerds\SystemConfigDiff\DataReader\StoreConfigDataReader
     */
    protected $_reader;

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->_reader = $objectManager->getObject('Magenerds\SystemConfigDiff\DataReader\StoreConfigDataReader');
    }

    public function testDiff()
    {
        $this->_reader->read();
    }
}