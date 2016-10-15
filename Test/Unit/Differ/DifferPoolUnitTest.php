<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Test\Unit\Differ;

use Magenerds\SystemDiff\Differ\DifferInterface;
use Magenerds\SystemDiff\Differ\DifferPool;
use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;

class DifferPoolUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DifferPool
     */
    private $sut;

    /**
     * @var TMap|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mapMock;

    /**
     * @var TMapFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $factoryMock;

    /**
     * Sets up the test.
     */
    protected function setUp()
    {
        $this->factoryMock = $this->getMockBuilder(TMapFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapMock = $this->getMockBuilder(TMap::class)
            ->disableOriginalConstructor()
            ->setMethods(['offsetGet', 'offsetExists'])
            ->getMock();

        $this->factoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->mapMock);

        $this->sut = new DifferPool($this->factoryMock, []);
    }

    /**
     * @test
     */
    public function itShouldReturnAnObjectByValidKey()
    {
        $validDifferMock = $this->getMockBuilder(DifferInterface::class)->getMock();
        $this->mapMock->expects($this->any())->method('offsetGet')->willReturn($validDifferMock);
        $this->mapMock->expects($this->any())->method('offsetExists')->willReturn(true);

        $this->assertSame($validDifferMock, $this->sut->get('example'));
    }
}