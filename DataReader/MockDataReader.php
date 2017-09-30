<?php


namespace Magenerds\SystemDiff\DataReader;


class MockDataReader implements DataReaderInterface
{

    public function read()
    {
        return ['mockconfig' => ['path' => 'value']];
        // TODO: Implement read() method.
    }
}