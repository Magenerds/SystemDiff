<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Test\Unit\DataWriter;

use Magenerds\SystemDiff\DataWriter\StoreConfigDataWriter;
use Magenerds\SystemDiff\Model\DiffConfig as DiffConfigModel;
use Magenerds\SystemDiff\Model\DiffConfigFactory as DiffConfigModelFactory;
use Magenerds\SystemDiff\Model\ResourceModel\DiffConfig as DiffConfigResource;
use Magento\Store\Model\StoreManagerInterface;
use PHPUnit\Framework\TestCase;

class StoreConfigDataWriterTest extends TestCase
{
    /**
     * @var DiffConfigResource
     */
    private $diffConfigResourceMock;

    /**
     * @var DiffConfigModelFactory
     */
    private $diffConfigModelFactoryMock;

    /**
     * @var DiffConfigModel
     */
    private $diffConfigModelMock;

    /**
     * @var StoreManagerInterface
     */
    private $storeManagerMock;

    /**
     * @var StoreConfigDataWriter
     */
    private $writer;

    /**
     * @var StoreConfigDataWriter
     */
    private $writerPartialMock;

    public function setUp()
    {
        $this->diffConfigResourceMock = $this->getMockBuilder(DiffConfigResource::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->diffConfigModelFactoryMock = $this->getMockBuilder(DiffConfigModelFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->diffConfigModelMock = $this->getMockBuilder(DiffConfigModel::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeManagerMock = $this->getMockBuilder(StoreManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->writer = new StoreConfigDataWriter(
            $this->diffConfigResourceMock,
            $this->diffConfigModelFactoryMock,
            $this->storeManagerMock
        );

        $this->writerPartialMock = $this->getMockBuilder(StoreConfigDataWriter::class)
            ->setConstructorArgs([
                $this->diffConfigResourceMock,
                $this->diffConfigModelFactoryMock,
                $this->storeManagerMock
            ])
            ->setMethods(['mapDataToModels'])
            ->getMock();


    }

    /**
     * Dataprovider for testWrite Method
     *
     * @return array
     */
    public function writeDataProvider()
    {
        return [
            'emptyInput' => [
                []
            ],
            'missingKey' => [
                [
                    'testKey123' => [
                        [
                            'default' => [
                                1 => 'test1',
                                2 => 'test2'
                            ]
                        ]
                    ]
                ]
            ],
            'emptyStoreConfig' => [
                ['storeConfig' => []]
            ],
            'wrongScopeKey' => [
                [
                    'storeConfig' => [
                        'testKey' => [
                            [
                                'default' => 'testValue'
                            ]
                        ]
                    ]
                ]
            ],
            'missingLocalKey' => [
                [
                    'storeConfig' => [
                        'testKey' => [
                            [
                                'default' => [
                                    1 => 'test1',
                                    2 => 'test2'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @test
     *
     * @param array $inputData
     *
     * @dataProvider writeDataProvider
     */
    public function testWrite(array $inputData)
    {
        $this->writerPartialMock->expects($this->never())->method('mapDataToModels');
        $this->diffConfigResourceMock->expects($this->never())->method('save');
        $this->writerPartialMock->write($inputData);
    }
}
