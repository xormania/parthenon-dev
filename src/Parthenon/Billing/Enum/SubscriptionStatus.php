<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2023.
 *
 * Use of this software is governed by the Business Source License included in the LICENSE file and at https://getparthenon.com/docs/next/license.
 *
 * Change Date: TBD ( 3 years after 2.2.0 release )
 *
 * On the date above, in accordance with the Business Source License, use of this software will be governed by the open source license specified in the LICENSE file.
 */

namespace Parthenon\Billing\Enum;

enum SubscriptionStatus: string
{
    case ACTIVE = 'active';
    case OVERDUE_PAYMENT_OPEN = 'overdue_payment_open';
    case OVERDUE_PAYMENT_DISABLED = 'overdue_payment_disabled';
    case PAUSED = 'paused';
    case CANCELLED = 'cancelled';
    case BLOCKED = 'blocked';
}