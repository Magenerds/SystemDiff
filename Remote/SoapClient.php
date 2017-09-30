<?php


namespace Magenerds\SystemDiff\Remote;


use Magenerds\SystemDiff\Model\ConfigData;

class SoapClient extends AbstractClient implements ClientInterface
{
    /**
     * @return \ArrayObject
     */
    public function fetch()
    {
        $opts = array(
                'http' => [
                    'header' => "Authorization: Bearer {$this->helper->getRemoteSystemAccessToken()}"
                ]
        );
        $streamContext = stream_context_create($opts);


        $httpClient = new \Zend_Soap_Client($this->helper->getRemoteSystemUrl());
        $httpClient->setOptions(
            [
                'stream_context' => $streamContext,
            ]
        );
        $response = $httpClient->magenerdsSystemDiffServiceFetchLocalDataServiceV1Fetch();

        if (isset($response->result->item)) {
            return new ConfigData(json_decode(json_encode($response->result->item), true));
        }

        return new \ArrayObject();
    }

}