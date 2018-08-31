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

/**
 * Message information for Pushwoosh notifications.
 */
class PushwooshMessage
{
    /**
     * The Pushwoosh application to target with this message.
     *
     * @var string|null
     */
    public $application;

    /**
     * @var string|null
     */
    public $subject;

    /**
     * The content of the notification.
     *
     * @var string
     */
    public $content;

    /**
     * Should the application icon badge number on the recipient's device be increased?
     *
     * @var bool
     */
    public $increaseBadgeNumber = true;

    /**
     * Extra data to send along with the notification.
     *
     * @var array
     */
    public $data = [];

    public function __construct(string $message = '')
    {
        $this->content = $message;
    }

    public function message(string $message)
    {
        $this->content = $message;

        return $this;
    }

    public function subject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function application(string $application)
    {
        $this->application = $application;

        return $this;
    }

    public function increaseBadgeNumber(bool $increaseBadgeNumber)
    {
        $this->increaseBadgeNumber = $increaseBadgeNumber;

        return $this;
    }

    public function data(array $data)
    {
        $this->data = $data;

        return $this;
    }
}
