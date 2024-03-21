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

namespace Parthenon\Notification\Sender;

use Parthenon\Notification\Attachment;
use Parthenon\Notification\Configuration;
use Parthenon\Notification\EmailInterface;
use PHPUnit\Framework\TestCase;
use SendGrid\Mail\Mail;
use SendGrid\Response;

class SendGridEmailSenderTest extends TestCase
{
    public const TO_EMAIL = 'to@example.org';
    public const FROM_EMAIL = 'from@example.org';
    public const SUBJECT = 'Subject';
    public const CONTENT = 'An email from a test';
    public const TEMPLATE_NAME = 'template_name';
    public const TEMPLATE_ARRAY = ['values' => 'value'];

    public function testSendsNonTemplate()
    {
        $mailer = $this->createMock(\SendGrid::class);
        $message = $this->createMock(EmailInterface::class);
        $configuration = $this->createMock(Configuration::class);

        $message->method('isTemplate')->willReturn(false);
        $configuration->method('getFromAddress')->willReturn(self::FROM_EMAIL);
        $configuration->method('getFromName')->willReturn(self::FROM_EMAIL);
        $message->method('getToAddress')->willReturn(self::TO_EMAIL);
        $message->method('getToName')->willReturn(self::TO_EMAIL);
        $message->method('getSubject')->willReturn(self::SUBJECT);
        $message->method('getContent')->willReturn(self::CONTENT);
        $message->method('getAttachments')->willReturn([]);

        $mailer->expects($this->once())->method('send')->with($this->isInstanceOf(Mail::class))->willReturn(new Response(202));

        $sender = new SendGridEmailSender($mailer, $configuration);
        $sender->send($message);
    }

    public function testSendsTemplate()
    {
        $mailer = $this->createMock(\SendGrid::class);
        $message = $this->createMock(EmailInterface::class);
        $configuration = $this->createMock(Configuration::class);

        $message->method('isTemplate')->willReturn(true);
        $configuration->method('getFromAddress')->willReturn(self::FROM_EMAIL);
        $configuration->method('getFromName')->willReturn(self::FROM_EMAIL);
        $message->method('getToAddress')->willReturn(self::TO_EMAIL);
        $message->method('getToName')->willReturn(self::TO_EMAIL);
        $message->method('getSubject')->willReturn(self::SUBJECT);
        $message->method('getTemplateName')->willReturn(self::TEMPLATE_NAME);
        $message->method('getTemplateVariables')->willReturn(self::TEMPLATE_ARRAY);
        $message->method('getAttachments')->willReturn([]);

        $mailer->expects($this->once())->method('send')->with($this->isInstanceOf(Mail::class))->willReturn(new Response(202));

        $sender = new SendGridEmailSender($mailer, $configuration);
        $sender->send($message);
    }

    public function testSendsTemplateWithAttachment()
    {
        $attachment = $this->createMock(Attachment::class);
        $mailer = $this->createMock(\SendGrid::class);
        $message = $this->createMock(EmailInterface::class);
        $configuration = $this->createMock(Configuration::class);

        $attachment->method('getContent')->willReturn('content here');
        $attachment->method('getName')->willReturn('text_file.txt');

        $message->method('isTemplate')->willReturn(true);
        $configuration->method('getFromAddress')->willReturn(self::FROM_EMAIL);
        $configuration->method('getFromName')->willReturn(self::FROM_EMAIL);
        $message->method('getToAddress')->willReturn(self::TO_EMAIL);
        $message->method('getToName')->willReturn(self::TO_EMAIL);
        $message->method('getSubject')->willReturn(self::SUBJECT);
        $message->method('getTemplateName')->willReturn(self::TEMPLATE_NAME);
        $message->method('getTemplateVariables')->willReturn(self::TEMPLATE_ARRAY);
        $message->method('getAttachments')->willReturn([$attachment]);

        $mailer->expects($this->once())->method('send')->with($this->isInstanceOf(Mail::class))->willReturn(new Response(202));

        $sender = new SendGridEmailSender($mailer, $configuration);
        $sender->send($message);
    }
}
