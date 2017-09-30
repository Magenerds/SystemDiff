<?php


namespace Magenerds\SystemDiff\Remote;

use Magenerds\SystemDiff\Api\Data\ConfigDataInterface;

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
            $data = json_decode($response->getBody());
            if (is_array($data)) {
                return new \ArrayObject($data);
            }
        }

        throw new \Exception("Request to remote was not successfull");
    }
}