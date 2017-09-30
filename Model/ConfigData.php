<?php


namespace Magenerds\SystemDiff\Model;


use Magenerds\SystemDiff\Api\Data\ConfigDataInterface;

class ConfigData implements ConfigDataInterface
{

    /**
     * ConfigData constructor.
     */
    public function __construct(array $data)
    {
        $this->data = new \ArrayObject($data);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}