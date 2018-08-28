<?php

/*
 * This file is part of the Laravel Pushwoosh package.
 *
 * (c) Contextmapp B.V. <support@contextmapp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Contextmapp\Pushwoosh\Tests;

use Contextmapp\Pushwoosh\Exceptions\ApplicationNotFoundException;
use Contextmapp\Pushwoosh\Exceptions\InvalidConfigurationException;
use Contextmapp\Pushwoosh\PushwooshFactory;
use Contextmapp\Pushwoosh\PushwooshManager;
use Gomoob\Pushwoosh\Client\Pushwoosh;
use PHPUnit\Framework\TestCase;

class PushwooshManagerTest extends TestCase
{
    const APP = 'default';
    const API_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
    const APP_ID = '12345-ABCDE';

    public function testApplication()
    {
        $config = [
            'application' => static::APP,
            'api_token' => static::API_TOKEN,
            'applications' => [
                static::APP => [
                    'application_id' => static::APP_ID,
                ],
            ],
        ];

        $application = $this->createMock(Pushwoosh::class);

        $factory = $this->createMock(PushwooshFactory::class);
        $factory->expects($this->once())->method('create')->with(static::APP_ID, static::API_TOKEN)->willReturn($application);

        $manager = new PushwooshManager($config, $factory);
        $this->assertEquals($application, $manager->application());
    }

    public function testUnknownApplication()
    {
        $config = [
            'application' => static::APP,
            'api_token' => static::API_TOKEN,
            'applications' => [
                static::APP => [
                    'application_id' => static::APP_ID,
                ],
            ],
        ];

        $factory = $this->createMock(PushwooshFactory::class);
        $factory->expects($this->never())->method('create');

        $this->expectException(ApplicationNotFoundException::class);

        $manager = new PushwooshManager($config, $factory);
        $manager->application('test');
    }

    public function testNoDefaultApplication()
    {
        $config = [
            'application' => null,
            'api_token' => static::API_TOKEN,
            'applications' => [
                static::APP => [
                    'application_id' => static::APP_ID,
                ],
            ],
        ];

        $factory = $this->createMock(PushwooshFactory::class);
        $factory->expects($this->never())->method('create');

        $this->expectException(InvalidConfigurationException::class);

        $manager = new PushwooshManager($config, $factory);
        $manager->application();
    }

    public function testNoApiToken()
    {
        $config = [
            'application' => static::APP,
            'api_token' => null,
            'applications' => [
                static::APP => [
                    'application_id' => static::APP_ID,
                ],
            ],
        ];

        $factory = $this->createMock(PushwooshFactory::class);
        $factory->expects($this->never())->method('create');

        $this->expectException(InvalidConfigurationException::class);

        $manager = new PushwooshManager($config, $factory);
        $manager->application();
    }

    public function testNoAppID()
    {
        $config = [
            'application' => static::APP,
            'api_token' => static::API_TOKEN,
            'applications' => [
                static::APP => [
                    'application_id' => null,
                ],
            ],
        ];

        $factory = $this->createMock(PushwooshFactory::class);
        $factory->expects($this->never())->method('create');

        $this->expectException(InvalidConfigurationException::class);

        $manager = new PushwooshManager($config, $factory);
        $manager->application();
    }
}
