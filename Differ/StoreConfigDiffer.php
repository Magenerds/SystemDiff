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
        $localConfig['default'] = $this->_flattenArray($localData['default'], '');
        $localConfig['websites'] = $this->_flattenArray($localData['websites'], '');
        $localConfig['stores'] = $this->_flattenArray($localData['stores'], '');
        $remoteConfig['default'] = $this->_flattenArray($remoteData['default'], '');
        $remoteConfig['websites'] = $this->_flattenArray($remoteData['websites'], '');
        $remoteConfig['stores'] = $this->_flattenArray($remoteData['stores'], '');

        $diff = array();
        $diff['default'] = $this->_diffArrays($localConfig['default'], $remoteConfig['default']);
        $diff['websites'] = $this->_diffArrays($localConfig['websites'], $remoteConfig['websites']);
        $diff['stores'] = $this->_diffArrays($localConfig['stores'], $remoteConfig['stores']);
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
    protected function _flattenArray($arr, $path)
    {
        $result = array();

        if(!is_array($arr)){
            return array(ltrim($path, '/') => $arr);
        }

        foreach($arr as $key => $value){
            $_path = $path;
            $_path = $_path . '/' . $key;
            $res = $this->_flattenArray($value, $_path);
            $result = array_merge($res, $result);
        }

        return $result;
    }
}