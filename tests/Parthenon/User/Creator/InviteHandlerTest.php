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

namespace Parthenon\User\Creator;

use Parthenon\User\Entity\InviteCode;
use Parthenon\User\Entity\User;
use Parthenon\User\Event\InvitedUserSignedUpEvent;
use Parthenon\User\Repository\InviteCodeRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class InviteHandlerTest extends TestCase
{
    public const CODE = 'code';

    public function testAssignUsersToInvite()
    {
        $inviteCodeRepository = $this->createMock(InviteCodeRepositoryInterface::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $inviteCode = $this->createMock(InviteCode::class);

        $user = new User();

        $inviteCodeRepository->method('findActiveByCode')->with($this->equalTo(self::CODE))->will($this->returnValue($inviteCode));

        $inviteCode->expects($this->once())->method('setInvitedUser')->with($this->equalTo($user));
        $inviteCode->expects($this->once())->method('setUsed')->with($this->equalTo(true));
        $inviteCode->expects($this->once())->method('setUsedAt')->with($this->isInstanceOf(\DateTime::class))->will($this->returnSelf());

        $eventDispatcher->expects($this->once())->method('dispatch')->with($this->isInstanceOf(InvitedUserSignedUpEvent::class), InvitedUserSignedUpEvent::NAME);

        $inviteHandler = new InviteHandler($inviteCodeRepository, $eventDispatcher, true);
        $inviteHandler->handleInvite($user, self::CODE);
    }
}
