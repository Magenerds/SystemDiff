<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\SystemDiff\Remote;

use Magenerds\SystemDiff\Model\ConfigData;

class SoapClient extends AbstractClient implements ClientInterface
{
    /**
     * @return ConfigData
     * @throws \Exception If response is faulty
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

        if (isset($response->result->data->string)) {
            return new ConfigData($this->buildDataFromJson($response->result->data->string));
        }

        throw new \Exception("SOAP response could not be read");
    }
}