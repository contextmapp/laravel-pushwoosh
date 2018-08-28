<?php

/*
 * This file is part of the Laravel Pushwoosh package.
 *
 * (c) Contextmapp B.V. <support@contextmapp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    /*
    |-------------------------------------------------------------------------
    | Default application
    |-------------------------------------------------------------------------
    | Which application should be targeted by default?
    */
    'application' => env('PUSHWOOSH_APPLICATION', 'default'),

    /*
    |-------------------------------------------------------------------------
    | API token
    |-------------------------------------------------------------------------
    | The API token for your Pushwoosh account.
    |
    | You can find your token at https://go.pushwoosh.com/v2/api_access
    */
    'api_token' => env('PUSHWOOSH_API_TOKEN', 'abcdefghijklmnopqrstuvwxyz'),

    /*
    |-------------------------------------------------------------------------
    | Pushwoosh Applications
    |-------------------------------------------------------------------------
    | Define any application you want to target through Pushwoosh.
    */
    'applications' => [
        'default' => [
            /*
            |-------------------------------------------------------------------------
            | Pushwoosh Application ID
            |-------------------------------------------------------------------------
            | The application ID you want to target when sending push messages.
            |
            | You can find your token at https://go.pushwoosh.com/v2/applications
            */
            'application_id' => env('PUSHWOOSH_APP_ID', '12345-ABCDE'),
        ],
    ],
];
