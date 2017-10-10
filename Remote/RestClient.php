<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

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
            $responseData = json_decode($response->getBody());

            if (isset($responseData->data[0])) {
                return $this->configDataFactory->create(['data' => $this->buildDataFromJson($responseData->data[0])]);
            }

            throw new \Exception("REST response could not be read");
        }

        // From here error state -> exception.
        $this->logger->error($response->getBody());
        throw new \Exception("Request to remote was not successfull");
    }
}