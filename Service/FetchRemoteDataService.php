<?php
/**
 * @copyright Copyright (c) 1999-2016 netz98 new media GmbH (http://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace Magenerds\SystemConfigDiff\Service;

use Magenerds\SystemConfigDiff\Api\Service\FetchRemoteDataServiceInterface;
use Magenerds\SystemConfigDiff\Remote\ClientInterface;

class FetchRemoteDataService implements FetchRemoteDataServiceInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function fetch()
    {
        return [];
    }
}