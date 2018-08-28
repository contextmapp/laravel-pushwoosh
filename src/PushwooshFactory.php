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

/**
 * Factory for Pushwoosh instances.
 */
class PushwooshFactory
{
    /**
     * Create a new Pushwoosh instance.
     *
     * @param string $application_id The Pushwoosh application ID
     * @param string $api_token The Pushwoosh API token for your organization (or a specific application)
     *
     * @return Pushwoosh
     */
    public function create(string $application_id, string $api_token): Pushwoosh
    {
        return Pushwoosh::create()
            ->setApplication($application_id)
            ->setAuth($api_token);
    }
}
