<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

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

        $localData = $this->validateArray($localData);
        $remoteData = $this->validateArray($remoteData);

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

        return $diff;
    }

    /**
     * Validates the given array if all necessary array keys exist. Otherwise an empty array is added.
     *
     * @param array $array
     * @return array
     */
    protected function validateArray(array $array)
    {
        if (!array_key_exists('default', $array)) {
            $array['default'] = [];
        }
        if (!array_key_exists('websites', $array)) {
            $array['websites'] = [];
        }
        if (!array_key_exists('stores', $array)) {
            $array['stores'] = [];
        }

        return $array;
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