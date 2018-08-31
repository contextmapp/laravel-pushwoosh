<?php

/*
 * This file is part of the Laravel Pushwoosh package.
 *
 * (c) Contextmapp B.V. <support@contextmapp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Contextmapp\Pushwoosh\Contracts;

use Contextmapp\Pushwoosh\PushwooshMessage;

/**
 * Implement this interface on notifications that should pass through the Pushwoosh channel.
 */
interface PushwooshNotification
{
    /**
     * Create the payload for the notification when routed through Pushwoosh.
     *
     * @param mixed $notifiable
     *
     * @return PushwooshMessage
     */
    public function toPushwoosh($notifiable): PushwooshMessage;
}
