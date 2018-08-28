<?php

/*
 * This file is part of the Laravel Pushwoosh package.
 *
 * (c) Contextmapp B.V. <support@contextmapp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Contextmapp\Pushwoosh\Facades;

use Gomoob\Pushwoosh\Client\Pushwoosh as PushwooshClient;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for the default Pushwoosh application.
 *
 * @method static PushwooshClient application()
 */
class Pushwoosh extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return PushwooshClient::class;
    }
}
