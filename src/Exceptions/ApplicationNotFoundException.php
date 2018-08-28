<?php

/*
 * This file is part of the Laravel Pushwoosh package.
 *
 * (c) Contextmapp B.V. <support@contextmapp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Contextmapp\Pushwoosh\Exceptions;

/**
 * ApplicationNotFoundException is thrown when an application is requested that is not configured.
 */
class ApplicationNotFoundException extends \UnexpectedValueException
{
    public function __construct(string $name)
    {
        parent::__construct("Configuration missing for application '$name'.");
    }
}
