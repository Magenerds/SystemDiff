<?php


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