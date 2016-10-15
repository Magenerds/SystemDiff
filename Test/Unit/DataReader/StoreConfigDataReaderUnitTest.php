<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Test\Unit\DataReader;

use Magenerds\SystemDiff\DataReader\StoreConfigDataReader;
use Magento\Store\Model\Config\Reader\DefaultReader;
use Magento\Store\Model\Config\Reader\Store;
use Magento\Store\Model\Config\Reader\Website;

class StoreConfigDataReaderUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DefaultReader|\PHPUnit_Framework_MockObject_MockObject
     */
    private $defaultReader;

    /**
     * @var Website|\PHPUnit_Framework_MockObject_MockObject
     */
    private $websiteReader;

    /**
     * @var Store|\PHPUnit_Framework_MockObject_MockObject
     */
    private $storeReader;

    /**
     * @var StoreConfigDataReader
     */
    private $reader;

    /**
     * Sets up the test.
     */
    protected function setUp()
    {
        $this->defaultReader = $this->getMockBuilder(DefaultReader::class)->disableOriginalConstructor()->getMock();
        $this->websiteReader = $this->getMockBuilder(Website::class)->disableOriginalConstructor()->getMock();
        $this->storeReader = $this->getMockBuilder(Store::class)->disableOriginalConstructor()->getMock();

        $this->reader = new StoreConfigDataReader(
            $this->defaultReader,
            $this->websiteReader,
            $this->storeReader
        );
    }

    /**
     * @test
     */
    public function itShouldReturnStoreConfigData()
    {
        $this->defaultReader
            ->expects($this->any())
            ->method('read')
            ->willReturn(['foo' => 'bar']);
        $this->websiteReader
            ->expects($this->any())
            ->method('read')
            ->willReturn(['foo' => 'bar']);
        $this->storeReader
            ->expects($this->any())
            ->method('read')
            ->willReturn(['foo' => 'bar']);

        $this->assertEquals(
            [
                'default' => ['foo' => 'bar'],
                'websites' => ['foo' => 'bar'],
                'stores' => ['foo' => 'bar']
            ],
            $this->reader->read()
        );
    }
}