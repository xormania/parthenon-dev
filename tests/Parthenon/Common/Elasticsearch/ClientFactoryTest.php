<?php

declare(strict_types=1);

/*
 * Copyright Humbly Arrogant Software Limited 2020-2023.
 *
 * Use of this software is governed by the Business Source License included in the LICENSE file and at https://getparthenon.com/docs/next/license.
 *
 * Change Date: 26.06.2026 ( 3 years after 2.2.0 release )
 *
 * On the date above, in accordance with the Business Source License, use of this software will be governed by the open source license specified in the LICENSE file.
 */

namespace Parthenon\Common\Elasticsearch;

use DG\BypassFinals;
use PHPUnit\Framework\TestCase;

class ClientFactoryTest extends TestCase
{
    public function setUp(): void
    {
        BypassFinals::enable();
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testItReturnsNormalHost()
    {
        $config = $this->createMock(Config::class);

        $config->method('getConnectionType')->willReturn(Config::CONNECTION_TYPE_NORMAL);
        $config->expects($this->once())->method('isNormalConnection')->willReturn(true);
        $config->method('isCloudBasedConnection')->willReturn(false);
        $config->method('hasBasicAuthSettings')->willReturn(false);
        $config->method('hasApiSettings')->willReturn(false);
        $config->expects($this->once())->method('getHosts')->willReturn(['https://localhost:9200']);

        $clientFactory = new ClientFactory($config);
        $this->assertInstanceOf(Client::class, $clientFactory->build());
    }

    public function testItReturnsNormalHostSetsApiKey()
    {
        $config = $this->createMock(Config::class);

        $config->method('getConnectionType')->willReturn(Config::CONNECTION_TYPE_NORMAL);
        $config->expects($this->once())->method('isNormalConnection')->willReturn(true);
        $config->method('isCloudBasedConnection')->willReturn(false);
        $config->method('hasBasicAuthSettings')->willReturn(false);
        $config->method('hasApiSettings')->willReturn(true);
        $config->expects($this->once())->method('getHosts')->willReturn(['https://localhost:9200']);
        $config->expects($this->once())->method('getApiKey')->willReturn('api_key');
        $config->expects($this->once())->method('getApiId')->willReturn('api_id');

        $clientFactory = new ClientFactory($config);
        $this->assertInstanceOf(Client::class, $clientFactory->build());
    }

    public function testItReturnsCloud()
    {
        $config = $this->createMock(Config::class);

        $config->method('getConnectionType')->willReturn(Config::CONNECTION_TYPE_NORMAL);
        $config->expects($this->once())->method('isNormalConnection')->willReturn(true);
        $config->method('isCloudBasedConnection')->willReturn(true);
        $config->method('hasBasicAuthSettings')->willReturn(false);
        $config->method('hasApiSettings')->willReturn(true);
        $config->expects($this->once())->method('getHosts')->willReturn(['https://localhost:9200']);
        $config->expects($this->once())->method('getApiKey')->willReturn('api_key');
        $config->expects($this->once())->method('getApiId')->willReturn('api_id');
        $config->expects($this->once())->method('getElasticCloudId')->willReturn('foo:'.base64_encode('localhost:9200$foo'));

        $clientFactory = new ClientFactory($config);
        $this->assertInstanceOf(Client::class, $clientFactory->build());
    }

    public function testItReturnsCloudBasicAuth()
    {
        $config = $this->createMock(Config::class);

        $config->method('getConnectionType')->willReturn(Config::CONNECTION_TYPE_NORMAL);
        $config->expects($this->once())->method('isNormalConnection')->willReturn(true);
        $config->method('isCloudBasedConnection')->willReturn(true);
        $config->method('hasBasicAuthSettings')->willReturn(true);
        $config->method('hasApiSettings')->willReturn(false);
        $config->expects($this->once())->method('getHosts')->willReturn(['https://localhost:9200']);
        $config->expects($this->never())->method('getApiKey')->willReturn('api_key');
        $config->expects($this->never())->method('getApiId')->willReturn('api_id');
        $config->expects($this->once())->method('getBasicUsername')->willReturn('username');
        $config->expects($this->once())->method('getBasicPassword')->willReturn('password');
        $config->expects($this->once())->method('getElasticCloudId')->willReturn('foo:'.base64_encode('localhost:9200$foo'));

        $clientFactory = new ClientFactory($config);
        $this->assertInstanceOf(Client::class, $clientFactory->build());
    }
}
