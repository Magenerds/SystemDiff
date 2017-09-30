<?php


namespace Magenerds\SystemDiff\Remote;

use Magenerds\SystemDiff\Api\Data\ConfigDataInterface;
use Magenerds\SystemDiff\Model\ConfigData;

class RestClient extends AbstractClient implements ClientInterface
{
    /**
     * @return ConfigDataInterface
     * @throws \Exception
     */
    public function fetch()
    {
        $httpClient = \Zend_Rest_Client::getHttpClient();
        $httpClient->setUri($this->helper->getRemoteSystemUrl());
        $httpClient->setHeaders('Authorization', "Bearer {$this->helper->getRemoteSystemAccessToken()}");
        $response = $httpClient->request(\Zend_Http_Client::GET);

        if ($response->isSuccessful()
            && strtolower($response->getHeader('Content-type')) === 'application/json; charset=utf-8'
        ) {
            $responseData = json_decode($response->getBody());

            if (isset($responseData->data[0])) {
                return new ConfigData($this->buildDataFromJson($responseData->data[0]));
            }

            throw new \Exception("SOAP response could not be read");
        }

        throw new \Exception("Request to remote was not successfull");
    }
}