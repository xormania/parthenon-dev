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

namespace Parthenon\AbTesting\Decider\EnabledDecider;

use Parthenon\AbTesting\Decider\EnabledDeciderInterface;

final class DeciderManager implements DecidedManagerInterface
{
    /**
     * @var EnabledDeciderInterface[]
     */
    private array $deciders = [];

    private bool $enabled;

    public function add(EnabledDeciderInterface $enabledDecider): void
    {
        $this->deciders[] = $enabledDecider;
    }

    public function isTestable(): bool
    {
        if (isset($this->enabled)) {
            return $this->enabled;
        }

        foreach ($this->deciders as $enabledDecider) {
            if (!$enabledDecider->isTestable()) {
                $this->enabled = false;

                return false;
            }
        }

        $this->enabled = true;

        return true;
    }
}
