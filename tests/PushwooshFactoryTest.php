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

use Contextmapp\Pushwoosh\PushwooshFactory;
use PHPUnit\Framework\TestCase;

class PushwooshFactoryTest extends TestCase
{
    public function testCreate()
    {
        $app_id = 'ABCDE-12345';
        $auth = 'abcdefghijklmnopqrstuvwxyz';

        $factory = new PushwooshFactory();
        $pushwoosh = $factory->create($app_id, $auth);

        $this->assertEquals($app_id, $pushwoosh->getApplication());
        $this->assertEquals($auth, $pushwoosh->getAuth());
    }
}
