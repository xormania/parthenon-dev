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

namespace Obol;

use Obol\Provider\ProviderInterface;

class Obol implements ObolInterface
{
    public function __construct(private ProviderInterface $provider)
    {
    }

    public function supportsHostedCheckout(): bool
    {
        // TODO: Implement supportsHostedCheckout() method.
    }

    public function supportsCustomerCreation(): bool
    {
        // TODO: Implement supportsCustomerCreation() method.
    }

    public function getCustomerService(): CustomerServiceInterface
    {
        // TODO: Implement getCustomerService() method.
    }
}
