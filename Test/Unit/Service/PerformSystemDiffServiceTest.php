<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Test\Unit\Service;

use Magenerds\SystemDiff\Helper\Config;
use Magenerds\SystemDiff\Service\DiffDataService;
use Magenerds\SystemDiff\Service\FetchLocalDataService;
use Magenerds\SystemDiff\Service\FetchRemoteDataService;
use Magenerds\SystemDiff\Service\PerformSystemDiffService;
use Magenerds\SystemDiff\Service\SaveDiffToTableService;

/**
 * Class PerformSystemDiffServiceTest
 * @package Magenerds\SystemDiff\Test\Unit\Service
 */
class PerformSystemDiffServiceTest extends \PHPUnit\Framework\TestCase
{
    /** @var  \Magenerds\SystemDiff\Service\PerformSystemDiffService */
    protected $testSubject;
    /** @var  \Magenerds\SystemDiff\Service\FetchLocalDataService|\PHPUnit_Framework_MockObject_MockObject */
    protected $fetchLocalDataService;
    /** @var  \Magenerds\SystemDiff\Service\FetchRemoteDataService|\PHPUnit_Framework_MockObject_MockObject */
    protected $fetchRemoteDataService;
    /** @var  \Magenerds\SystemDiff\Service\DiffDataService|\PHPUnit_Framework_MockObject_MockObject */
    protected $diffDataService;
    /** @var  \Magenerds\SystemDiff\Service\SaveDiffToTableService|\PHPUnit_Framework_MockObject_MockObject */
    protected $saveDataToTableService;
    /** @var  \Magenerds\SystemDiff\Helper\Config|\PHPUnit_Framework_MockObject_MockObject */
    protected $helperConfig;

    /**
     * Prepare test subject
     */
    protected function setUp()
    {
        $this->fetchLocalDataService = $this->getMockBuilder(FetchLocalDataService::class)
            ->setMethods(['fetch'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->fetchRemoteDataService = $this->getMockBuilder(FetchRemoteDataService::class)
            ->setMethods(['fetch'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->diffDataService = $this->getMockBuilder(DiffDataService::class)
            ->setMethods(['diffData'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->saveDataToTableService = $this->getMockBuilder(SaveDiffToTableService::class)
            ->setMethods(['saveData'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->helperConfig = $this->getMockBuilder(Config::class)
            ->setMethods(['isEnabled'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->testSubject = new PerformSystemDiffService(
            $this->fetchLocalDataService,
            $this->fetchRemoteDataService,
            $this->diffDataService,
            $this->saveDataToTableService,
            $this->helperConfig
        );
    }

    /**
     * @test
     */
    public function performDiff()
    {

        $this->helperConfig->expects($this->any())->method('isEnabled')->willReturn(true);
        $localData = ['foo' => 'bar'];
        $remoteData = ['faz' => 'baz'];

        $diffData = ['bla' => 'blub'];

        $this->fetchLocalDataService->expects($this->once())->method('fetch')->willReturn($localData);
        $this->fetchRemoteDataService->expects($this->once())->method('fetch')->willReturn($remoteData);
        $this->diffDataService->expects($this->once())->method('diffData')->with(
            $this->equalTo($localData),
            $this->equalTo($remoteData)
        )
            ->willReturn($diffData);
        $this->saveDataToTableService->expects($this->once())->method('saveData')->with($this->equalTo($diffData));

        // GO!
        $this->testSubject->performDiff();
    }
}