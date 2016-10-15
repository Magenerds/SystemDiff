<?php

namespace Magenerds\SystemConfigDiff\Differ;

class StoreConfigDiffer extends AbstractDiffer
{
    /**
     * Diffs two data sets of two systems.
     *
     * @param array $localData
     * @param array $remoteData
     * @return array
     */
    public function diff(array $localData, array $remoteData)
    {
        $localConfig = [];
        $remoteConfig = [];
        $localConfig['default'] = $this->flattenArray($localData['default'], '');
        $localConfig['websites'] = $this->flattenArray($localData['websites'], '');
        $localConfig['stores'] = $this->flattenArray($localData['stores'], '');
        $remoteConfig['default'] = $this->flattenArray($remoteData['default'], '');
        $remoteConfig['websites'] = $this->flattenArray($remoteData['websites'], '');
        $remoteConfig['stores'] = $this->flattenArray($remoteData['stores'], '');

        $diff = array();
        $diff['default'] = $this->diffArrays($localConfig['default'], $remoteConfig['default']);
        $diff['websites'] = $this->diffArrays($localConfig['websites'], $remoteConfig['websites']);
        $diff['stores'] = $this->diffArrays($localConfig['stores'], $remoteConfig['stores']);
    }

    /**
     * Depth first search algorithm to flatten an multi associative array.
     * All keys will be merged to a path, separated by /
     * The last value (leaf of tree) will be stored as: path => value
     *
     * @param $arr
     * @param $path
     * @return array
     */
    protected function flattenArray($arr, $path)
    {
        $result = array();

        if(!is_array($arr)){
            return array(ltrim($path, '/') => $arr);
        }

        foreach($arr as $key => $value){
            $_path = $path;
            $_path = $_path . '/' . $key;
            $res = $this->flattenArray($value, $_path);
            $result = array_merge($res, $result);
        }

        return $result;
    }
}