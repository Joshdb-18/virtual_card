<?php

namespace VirtualCard\Vendor\Lion\Service;

use GuzzleHttp\Exception\GuzzleException;
use VirtualCard\Entity\VirtualCard;
use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Schema\Vendor\Remove\Result as RemoveResult;
use VirtualCard\Service\VendorServiceLoader;
use VirtualCard\Vendor\Lion\Response\Parser\RemoveResponseParser;
use VirtualCard\Vendor\Lion\Service\Client\ClientWrapper;
use VirtualCard\Vendor\RemoveInterface;
use VirtualCard\Vendor\VendorServiceInterface;

class Remove implements RemoveInterface, VendorServiceInterface
{
    /**
     * @var ClientWrapper
     */
    private $clientWrapper;

    public function __construct(ClientWrapper $clientWrapper)
    {
        $this->clientWrapper = $clientWrapper;
    }

    /**
     * @param VirtualCard $virtualCard
     * @return RemoveResult
     * @throws RouterMethodNotFoundException
     * @throws GuzzleException
     */
    public function getResult(VirtualCard $virtualCard): RemoveResult
    {
        $response = $this->clientWrapper->request(VendorServiceLoader::REMOVE, $virtualCard->getProcessId());

        return RemoveResponseParser::parse((string)$response->getBody());
    }
}
