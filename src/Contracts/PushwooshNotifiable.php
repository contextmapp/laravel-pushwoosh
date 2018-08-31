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

use Gomoob\Pushwoosh\Model\Condition\ICondition;

/**
 * Implement this interface on the classes that include the {@link \Illuminate\Notifications\Notifiable} trait
 * and should have routing for Pushwoosh notifications.
 */
interface PushwooshNotifiable
{
    /**
     * Set the Pushwoosh conditions that target the intended user.
     *
     * @return ICondition[]
     */
    public function routeNotificationForPushwoosh(): array;
}
