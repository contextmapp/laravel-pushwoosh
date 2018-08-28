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

/**
 * PushwooshManager contains the copies of all instantiated Pushwoosh applications and can create them when necessary.
 *
 * @mixin Pushwoosh
 */
class PushwooshManager
{
    private $config;
    private $factory;
    private $applications = [];

    /**
     * PushwooshManager constructor.
     * @param array $config The configuration for the available Pushwoosh applications.
     * @param PushwooshFactory $factory The Pushwoosh instance factory.
     */
    public function __construct(array $config, PushwooshFactory $factory)
    {
        $this->config = $config;
        $this->factory = $factory;
    }

    /**
     * Get a Pushwoosh application instance.
     *
     * @param string? $name The name of the application (if none given, the default application is taken from configuration)
     *
     * @return Pushwoosh A configured Pushwoosh instance
     *
     * @throws ApplicationNotFoundException when the application is not configured
     * @throws InvalidConfigurationException when the application configuration does not contain the required elements
     */
    public function application(string $name = null): Pushwoosh
    {
        if (null === $name) {
            $name = $this->getDefaultApplication();
        }

        $this->applications[$name] = $this->makeApplication($name);

        return $this->applications[$name];
    }

    /**
     * Get the name of the default Pushwoosh application.
     *
     * @return string The name of the application
     *
     * @throws InvalidConfigurationException when no default application is configured
     */
    private function getDefaultApplication(): string
    {
        if (empty($this->config['application'])) {
            throw new InvalidConfigurationException('The default application is not set.');
        }

        return $this->config['application'];
    }

    /**
     * Create a new Pushwoosh application instance.
     *
     * @param string $name The application name
     *
     * @return Pushwoosh The configured Pushwoosh instance
     *
     * @throws ApplicationNotFoundException when the application is not configured
     * @throws InvalidConfigurationException when the application configuration does not contain the required elements
     */
    private function makeApplication(string $name): Pushwoosh
    {
        $config = $this->getApplicationConfiguration($name);

        if (empty($this->config['api_token'])) {
            throw new InvalidConfigurationException('The Pushwoosh API token is not set.');
        }

        if (empty($config['application_id'])) {
            throw new InvalidConfigurationException("The application ID is not set for application '$name'.");
        }

        return $this->factory->create($config['application_id'], $this->config['api_token']);
    }

    /**
     * Get the application configuration object for the given application.
     *
     * @param string $name The application name
     *
     * @return array The configuration object
     *
     * @throws ApplicationNotFoundException when the application is not configured
     */
    private function getApplicationConfiguration(string $name): array
    {
        if (false === array_key_exists($name, $this->config['applications'])) {
            throw new ApplicationNotFoundException($name);
        }

        return $this->config['applications'][$name];
    }

    /**
     * Proxy any unknown function call to the default Pushwoosh application.
     *
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     *
     * @throws ApplicationNotFoundException
     * @throws InvalidConfigurationException
     */
    public function __call(string $method, array $arguments)
    {
        return $this->application()->$method(...$arguments);
    }
}
