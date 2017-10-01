<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Api\Data;

interface ConfigDataInterface
{
    /**
     * This method MUST return an array with an index "0" which contains the actual data.
     *
     * This is a requirement of the REST/SOAP API, else the first index is cut out.
     *
     * @return mixed|array
     */
    public function getData();
}