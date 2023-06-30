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

namespace App\Dummy\Provider;

use Obol\Model\CreatePrice;
use Obol\Model\Price;
use Obol\Model\PriceCreation;
use Obol\PriceServiceInterface;

class PriceService implements PriceServiceInterface
{
    public function createPrice(CreatePrice $createPrice): PriceCreation
    {
        $priceCreation = new PriceCreation();
        $priceCreation->setReference(bin2hex(random_bytes(32)));

        return $priceCreation;
    }

    public function fetch(string $priceId): Price
    {
        // TODO: Implement fetch() method.
    }

    public function list(int $limit = 10, ?string $lastId = null): array
    {
        // TODO: Implement list() method.
    }
}
