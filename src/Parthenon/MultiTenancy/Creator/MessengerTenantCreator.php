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

namespace Parthenon\MultiTenancy\Creator;

use Parthenon\MultiTenancy\Entity\TenantInterface;
use Parthenon\MultiTenancy\Exception\TenantCreationFailureException;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerTenantCreator implements TenantCreatorInterface
{
    public function __construct(private MessageBusInterface $messengerBus)
    {
    }

    public function createTenant(TenantInterface $tenant): void
    {
        try {
            $this->messengerBus->dispatch($tenant);
        } catch (\Exception $e) {
            throw new TenantCreationFailureException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
