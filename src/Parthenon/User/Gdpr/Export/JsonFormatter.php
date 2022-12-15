<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the Business Source License included in the LICENSE file and at https://getparthenon.com/docs/next/license.
 *
 * Change Date: 16.12.2025
 *
 * On the date above, in accordance with the Business Source License, use of this software will be governed by the open source license specified in the LICENSE file.
 */

namespace Parthenon\User\Gdpr\Export;

use Parthenon\User\Entity\UserInterface;

final class JsonFormatter implements FormatterInterface
{
    public function getName(): string
    {
        return 'json';
    }

    public function getFilename(UserInterface $user): string
    {
        return 'user-export.json';
    }

    public function format(array $data): string
    {
        return json_encode($data);
    }
}
