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

use Gomoob\Pushwoosh\Client\Pushwoosh;

class PushwooshFactory
{
    public function create(string $application_id, string $api_token): Pushwoosh
    {
        return Pushwoosh::create()
            ->setApplication($application_id)
            ->setAUth($api_token);
    }
}
