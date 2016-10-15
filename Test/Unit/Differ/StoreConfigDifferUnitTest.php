<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Test\Unit\Differ;

use Magenerds\SystemDiff\Differ\StoreConfigDiffer;

class StoreConfigDifferUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StoreConfigDiffer
     */
    private $differ;

    /**
     * Sets up the test.
     */
    protected function setUp()
    {
        $this->differ = new StoreConfigDiffer();
    }

    public function testDiff()
    {
        $diffData1 =
            [
                'default' => [
                    'foo' => [
                        'bar' => [
                            'fooconfig' => 'foobar'
                        ]
                    ]
                ],
                'websites' => [
                    'foo' => [
                        'bar' => [
                            'fooconfig' => 'foobar'
                        ]
                    ]
                ],
                'stores' => []
            ];
        $diffData2 =
            [
                'default' => [
                    'foo' => [
                        'bar' => [
                            'fooconfig' => 'barfoo'
                        ]
                    ]
                ],
                'websites' => [
                    'foo' => [
                        'bar' => [
                            'fooconfig' => 'foobar'
                        ]
                    ]
                ],
                'stores' => []
            ];

        $this->assertEquals(
            [
                'default' => [
                    1 => [
                        'foo/bar/fooconfig' => 'foobar'
                    ],
                    2 => [
                        'foo/bar/fooconfig' => 'barfoo'
                    ]
                ],
                'websites' => [
                    1 => [],
                    2 => []
                ],
                'stores' => [
                    1 => [],
                    2 => []
                ]
            ],
            $this->differ->diff($diffData1, $diffData2)
        );
    }
}