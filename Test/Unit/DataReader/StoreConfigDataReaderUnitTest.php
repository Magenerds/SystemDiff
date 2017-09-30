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
use Magento\Framework\App\Config\ConfigSourceInterface;

/**
 * Class StoreConfigDataReaderUnitTest
 * @package Magenerds\SystemDiff\Test\Unit\DataReader
 */
class StoreConfigDataReaderUnitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Framework\App\Config\ConfigSourceInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $configSource;

    /**
     * @var StoreConfigDataReader
     */
    private $reader;

    /**
     * Sets up the test.
     */
    protected function setUp()
    {
        $this->configSource = $this->getMockBuilder(ConfigSourceInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $this->reader = new StoreConfigDataReader(
            $this->configSource
        );
    }

    /**
     * @test
     */
    public function itShouldReturnStoreConfigData()
    {
        $configArr = [
            'default' => ['foo' => 'bar'],
            'websites' => ['foo' => 'bar'],
            'stores' => ['foo' => 'bar']
        ];

        $this->configSource->expects($this->once())
            ->method('get')
            ->willReturn($configArr);


        $this->assertEquals(
            $configArr,
            $this->reader->read()
        );
    }
}