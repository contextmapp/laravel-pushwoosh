<?php

/*
 * This file is part of the Laravel Pushwoosh package.
 *
 * (c) Contextmapp B.V. <support@contextmapp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Contextmapp\Pushwoosh;

use Contextmapp\Pushwoosh\Contracts\PushwooshNotifiable;
use Contextmapp\Pushwoosh\Contracts\PushwooshNotification;
use Contextmapp\Pushwoosh\Exceptions\NotificationFailedException;
use Gomoob\Pushwoosh\Exception\PushwooshException;
use Gomoob\Pushwoosh\Model\Notification\Android;
use Gomoob\Pushwoosh\Model\Notification\IOS;
use Gomoob\Pushwoosh\Model\Request\CreateMessageRequest;
use Illuminate\Notifications\Notification;

/**
 * Channel for dispatching notifications through Pushwoosh.
 */
class PushwooshChannel
{
    const NAME = 'pushwoosh';

    private $manager;

    /**
     * PushwooshChannel constructor.
     *
     * @param PushwooshManager $manager
     */
    public function __construct(PushwooshManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Send the notification through the Pushwoosh notification channel.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if ((!$notifiable instanceof PushwooshNotifiable) || (!$notification instanceof PushwooshNotification)) {
            return;
        }

        $message = $notification->toPushwoosh($notifiable);
        $request = $this->buildRequest($notifiable, $message);

        try {
            $response = $this->manager->application($message->application)->createMessage($request);
        } catch (PushwooshException $e) {
            throw new NotificationFailedException('Failed to send notification to Pushwoosh', 0, $e);
        }

        if (false === $response->isOk()) {
            throw new NotificationFailedException('Failed to send notification to Pushwoosh', $response->getStatusCode());
        }
    }

    /**
     * Build the request to send to Pushwoosh.
     *
     * @param \Contextmapp\Pushwoosh\Contracts\PushwooshNotifiable $notifiable
     * @param \Contextmapp\Pushwoosh\PushwooshMessage $message
     *
     * @return \Gomoob\Pushwoosh\Model\Request\CreateMessageRequest
     */
    private function buildRequest(PushwooshNotifiable $notifiable, PushwooshMessage $message): CreateMessageRequest
    {
        $android = new Android();
        $ios = new IOS();

        $notification = new \Gomoob\Pushwoosh\Model\Notification\Notification();
        $notification->setContent($message->content);
        $notification->setData($message->data);
        $notification->setAndroid($android);
        $notification->setIOS($ios);

        if ($message->subject) {
            $android->setHeader($message->subject);
        }

        if ($message->increaseBadgeNumber) {
            $android->setBadges('+1');
            $ios->setBadges('+1');
        }

        $notification->setConditions($notifiable->routeNotificationForPushwoosh());

        $request = new CreateMessageRequest();
        $request->addNotification($notification);

        return $request;
    }
}
