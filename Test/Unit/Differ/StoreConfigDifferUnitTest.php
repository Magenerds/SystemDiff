<?php

namespace Magenerds\SystemConfigDiff\Test\Unit\Differ;


class StoreConfigDifferUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magenerds\SystemConfigDiff\Differ\StoreConfigDiffer
     */
    protected $_differ;

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->_differ = $objectManager->getObject('Magenerds\SystemConfigDiff\Differ\StoreConfigDiffer');
    }

    public function testDiff()
    {
        $this->_differ->diff(
            [
                'default' => [
                    'design' => [
                        'pagination' => [
                            'list_allow_all' => '1',
                            'pagination_frame' => '5'
                        ],
                        'head' => [
                            'includes' => '<link  rel="stylesheet" type="text/css"  media="all" href="{{MEDIA_URL}}styles.css" />'
                        ]
                    ]
                ],
                'websites' => [],
                'stores' => []
            ],
            [
                'default' => [
                    'design' => [
                        'pagination' => [
                            'list_allow_all' => '1',
                            'pagination_frame' => '6'
                        ],
                        'head' => [
                            'includes' => '<link  rel="stylesheet" type="text/css"  media="all" href="{{MEDIA_URL}}styles.css" />'
                        ]
                    ]
                ],
                'websites' => [],
                'stores' => []
            ]
        );
    }
}