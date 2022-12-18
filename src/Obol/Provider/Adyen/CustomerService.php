<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the Business Source License included in the LICENSE file and at https://getparthenon.com/docs/next/license.
 *
 * Change Date: TBD ( 3 years after 2.2.0 release )
 *
 * On the date above, in accordance with the Business Source License, use of this software will be governed by the open source license specified in the LICENSE file.
 */

namespace Obol\Provider\Adyen;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Obol\Config;
use Obol\CustomerServiceInterface;
use Obol\Exception\BadAuthFailedRequestException;
use Obol\Exception\FailedRequestException;
use Obol\Exception\InvalidFieldsFailedRequestException;
use Obol\Models\Customer;
use Obol\Models\CustomerCreationResponse;
use Obol\Provider\Adyen\DataMapper\CustomerMapperInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class CustomerService implements CustomerServiceInterface
{
    private const TEST_BASE_URL = 'https://kyc-test.adyen.com/lem/v2/legalEntities';
    private const LIVE_BASE_URL = 'https://kyc-live.adyen.com/lem/v2/legalEntities';
    private ClientInterface $client;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private string $baseUrl;

    public function __construct(private Config $config, private CustomerMapperInterface $customerMapper, ?ClientInterface $client, ?RequestFactoryInterface $requestFactory, ?StreamFactoryInterface $streamFactory)
    {
        $this->client = $client ?? Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
        $this->baseUrl = $this->config->isTestMode() ? self::TEST_BASE_URL : self::LIVE_BASE_URL;
    }

    public function createCustomer(Customer $customer): CustomerCreationResponse
    {
        $payload = $this->customerMapper->mapCustomer($customer);

        $request = $this->requestFactory->createRequest('POST', $this->baseUrl);
        $stream = $this->streamFactory->createStream(json_encode($payload));
        $request->withBody($stream);

        $response = $this->client->sendRequest($request);

        $customerCreation = new CustomerCreationResponse();

        $jsonData = json_decode($response->getBody()->getContents(), true);
        if (200 === $response->getStatusCode()) {
            $customerCreation->setId($jsonData['id']);

            return $customerCreation;
        }

        if (422 === $response->getStatusCode()) {
            throw new InvalidFieldsFailedRequestException($jsonData['invalidFields'], $response);
        }

        if (401 === $response->getStatusCode() || 403 === $response->getStatusCode()) {
            throw new BadAuthFailedRequestException($request);
        }
        // All other responses are a failure
        throw new FailedRequestException($request);
    }

    public function fetchCustomer(int|string $id): Customer
    {
        // TODO: Implement fetchCustomer() method.
    }
}
