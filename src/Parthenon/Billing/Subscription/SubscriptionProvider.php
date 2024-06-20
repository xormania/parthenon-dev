<?php

declare(strict_types=1);

/*
 * Copyright (C) 2020-2024 Iain Cambridge
 *
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace Parthenon\Billing\Subscription;

use Parthenon\Billing\Entity\CustomerInterface;
use Parthenon\Billing\Entity\Subscription;
use Parthenon\Billing\Repository\SubscriptionRepositoryInterface;

class SubscriptionProvider implements SubscriptionProviderInterface
{
    public function __construct(private SubscriptionRepositoryInterface $subscriptionRepository)
    {
    }

    public function getSubscriptionsForCustomer(CustomerInterface $customer): array
    {
        return $this->subscriptionRepository->getAllActiveForCustomer($customer);
    }

    public function getSubscription(string $id): Subscription
    {
        return $this->subscriptionRepository->getById($id);
    }
}