<?php


namespace Magenerds\SystemDiff\Remote;


interface ClientAdapterInterface
{
    /**
     * Returns the client to use for FetchRemoteDataService
     *
     * @return ClientInterface
     */
    public function getClient() : ClientInterface;
}