<?php

/*
 * This file is part of the Laravel Pushwoosh package.
 *
 * (c) Contextmapp B.V. <support@contextmapp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Contextmapp\Pushwoosh\Tests;

use Contextmapp\Pushwoosh\Contracts\PushwooshNotifiable;
use Contextmapp\Pushwoosh\Contracts\PushwooshNotification;
use Contextmapp\Pushwoosh\Exceptions\NotificationFailedException;
use Contextmapp\Pushwoosh\PushwooshChannel;
use Contextmapp\Pushwoosh\PushwooshManager;
use Contextmapp\Pushwoosh\PushwooshMessage;
use Gomoob\Pushwoosh\Client\Pushwoosh;
use Gomoob\Pushwoosh\Exception\PushwooshException;
use Gomoob\Pushwoosh\Model\Condition\IntCondition;
use Gomoob\Pushwoosh\Model\IResponse;
use Gomoob\Pushwoosh\Model\IRequest;
use Illuminate\Notifications\Notification;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PushwooshChannelTest extends TestCase
{
    public function testSend()
    {
        $notifiable = $this->buildPushwooshNotifiable();
        $notification = $this->buildPushwooshNotification($notifiable);
        $manager = $this->buildPushwooshManager(false, false);

        $channel = new PushwooshChannel($manager);
        $channel->send($notifiable, $notification);
    }

    public function testSendError()
    {
        $notifiable = $this->buildPushwooshNotifiable();
        $notification = $this->buildPushwooshNotification($notifiable);
        $manager = $this->buildPushwooshManager(true, false);

        $this->expectException(NotificationFailedException::class);

        $channel = new PushwooshChannel($manager);
        $channel->send($notifiable, $notification);
    }

    public function testSendFails()
    {
        $notifiable = $this->buildPushwooshNotifiable();
        $notification = $this->buildPushwooshNotification($notifiable);
        $manager = $this->buildPushwooshManager(false, true);

        $this->expectException(NotificationFailedException::class);

        $channel = new PushwooshChannel($manager);
        $channel->send($notifiable, $notification);
    }

    private function buildPushwooshManager(bool $throws, bool $fails): MockObject
    {
        $response = $this->createMock(IResponse::class);
        $response->expects($throws ? $this->never() : $this->once())->method('isOk')->willReturn(!$fails);
        $response->expects($throws || !$fails ? $this->never() : $this->once())->method('getStatusCode')->willReturn(500);

        $pushwoosh = $this->createMock(Pushwoosh::class);
        $method = $pushwoosh->expects($this->once())->method('createMessage')->with($this->isInstanceOf(IRequest::class));
        if ($throws) {
            $method->willThrowException(new PushwooshException);
        } else {
            $method->willReturn($response);
        }

        $manager = $this->createMock(PushwooshManager::class);
        $manager->expects($this->once())->method('application')->with(null)->willReturn($pushwoosh);

        return $manager;
    }

    private function buildPushwooshNotifiable(): MockObject
    {
        $conditions = [IntCondition::create('userId')->eq('12')];

        $notifiable = $this->createMock(PushwooshNotifiable::class);
        $notifiable->expects($this->once())->method('routeNotificationForPushwoosh')->willReturn($conditions);

        return $notifiable;
    }

    private function buildPushwooshNotification($notifiable): PushwooshNotification
    {
        $notification = $this->prophesize(Notification::class)
            ->willImplement(PushwooshNotification::class);
        $notification->toPushwoosh($notifiable)->shouldBeCalledTimes(1)->willReturn(new PushwooshMessage());

        return $notification->reveal();
    }
}
