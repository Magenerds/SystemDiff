<?php

namespace Magenerds\SystemConfigDiff\Test\Unit\Differ;

use Magenerds\SystemConfigDiff\Api\DifferInterface;
use Magenerds\SystemConfigDiff\Differ\DifferPool;
use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;

class DifferPoolUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TMap|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mapMock;

    /**
     * @var TMapFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $factoryMock;

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