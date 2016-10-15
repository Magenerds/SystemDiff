<?php

namespace Magenerds\SystemConfigDiff\Test\Unit\Service;

use Magenerds\SystemConfigDiff\Differ\DifferInterface;
use Magenerds\SystemConfigDiff\Differ\DifferPool;
use Magenerds\SystemConfigDiff\Service\DiffDataService;

class DiffDataServiceUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DifferPool|\PHPUnit_Framework_MockObject_MockObject
     */
    private $differPoolMock;

    /**
     * @var DiffDataService
     */
    private $sut;

    protected function setUp()
    {
        $this->differPoolMock = $this->getMockBuilder(DifferPool::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sut = new DiffDataService(
            $this->differPoolMock
        );
    }

    /**
     * @test
     */
    public function diffData()
    {
        $localData = ['foo' => 1];
        $remoteData = ['foo' => 2];
        $exampleDifferenceResult = ['foo' => 2];

        $differMock = $this->getMockBuilder(DifferInterface::class)->getMock();

        $differMock
            ->expects($this->once())
            ->method('diff')
            ->with($localData, $remoteData)
            ->willReturn($exampleDifferenceResult);

        $this->differPoolMock
            ->expects($this->any())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator(['example' => $differMock]));

        $differences = $this->sut->diffData($localData, $remoteData);
        $this->assertArrayHasKey('example', $differences);
        $this->assertEquals(['example' => $exampleDifferenceResult], $differences);
    }
}