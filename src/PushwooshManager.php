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

use Contextmapp\Pushwoosh\Exceptions\ApplicationNotFoundException;
use Contextmapp\Pushwoosh\Exceptions\InvalidConfigurationException;
use Gomoob\Pushwoosh\Client\Pushwoosh;

class PushwooshManager
{
    private $config;
    private $factory;
    private $applications = [];

    public function __construct(array $config, PushwooshFactory $factory)
    {
        $this->config = $config;
        $this->factory = $factory;
    }

    public function application(string $name = null): Pushwoosh
    {
        if (null === $name) {
            $name = $this->getDefaultApplication();
        }

        $this->applications[$name] = $this->makeApplication($name);

        return $this->applications[$name];
    }

    private function getDefaultApplication(): string
    {
        if (empty($this->config['application'])) {
            throw new InvalidConfigurationException('The default application is not set.');
        }

        return $this->config['application'];
    }

    private function makeApplication(string $name): Pushwoosh
    {
        $config = $this->getApplicationConfiguration($name);

        if (empty($this->config['api_token'])) {
            throw new InvalidConfigurationException('The Pushwoosh API token is not set.');
        }

        if (empty($config['application_id'])) {
            throw new InvalidConfigurationException("The application ID is not set for application '$name'.");
        }

        return $this->factory->make($config['application_id'], $this->config['api_token']);
    }

    private function getApplicationConfiguration(string $name): array
    {
        if (false === array_key_exists($name, $this->config['applications'])) {
            throw new ApplicationNotFoundException($name);
        }

        return $this->config['applications'][$name];
    }

    public function __call(string $method, array $arguments)
    {
        return $this->application()->$method(...$arguments);
    }
}
