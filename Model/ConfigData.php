<?php


namespace Magenerds\SystemDiff\Model;


use Magenerds\SystemDiff\Api\Data\ConfigDataInterface;

class ConfigData implements ConfigDataInterface
{

    /**
     * ConfigData constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @inheritdoc
     * @return mixed|array
     */
    public function getData()
    {
        return [$this->data];
    }
}