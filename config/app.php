<?php

/*
 * configuration required by the MSGraphAuth and MSGraph components
 */
return [
    'Cache' => [
        'forever' => [
            'className' => 'File',
            'duration' => '+999 years',
            'path' => CACHE,
            'prefix' => 'cake_forever_',
        ],
        'profileimage' => [
            'className' => 'File',
            'duration' => '+12 hours',
            'path' => CACHE . 'profileimage',
        ],
        'files' => [
            'className' => 'File',
            'duration' => '+1 month',
            'path' => CACHE . 'files',
        ],
        'resized' => [
            'className' => 'File',
            'duration' => '+2 weeks',
            'path' => CACHE . 'resized',
        ],
        'MSGraph' => [
            'className' => 'File',
            'duration' => '+55 minutes',
            'path' => CACHE,
            'prefix' => 'cake_msgraph_',
        ],
    ],

    'store' => [
        'stylesheets' => [
            'css/scc-base.min.css',
        ],
    ],

    /**
     * MS Graph API
     * api reference at https://docs.microsoft.com/en-us/graph/api/overview
     * application registered at https://apps.dev.microsoft.com
     */
    'MSGraph' => [
        'Common' => [
            'auth_url' => 'https://login.microsoftonline.com/',
            'api_url' => 'https://graph.microsoft.com/v1.0/',
            'tenant' => 'ad7d388d-6dd1-42fc-a564-2995ef86cf2b', // Azure AD GUI
            'response_type' => 'code',
            'redirect_uri' => ['controller' => 'Session', 'action' => 'start'],
            'response_mode' => 'query',
            'redirect_alt_uri' => 'https://' . ($_SERVER['HTTP_HOST'] ?? '') . '/oauthfwd',
        ],
        'Auth' => [
            'application_id' => '84509336-1dc6-4943-919c-4996efbcd1bf',
            'scope_service' => 'offline_access user.read',
            'scope' => 'offline_access user.read',
            'client_secret' => 'f#zy;pv;1jz[#^??G;rZG(}hs#c)]^}*?}4rFlJzQ}W*$=mbZ=W=:',
        ],
        'Service' => [
            'application_id' => 'cbff62d7-965e-4abe-b6bf-f1b489f30035',
            'scope' => 'offline_access user.read user.read.all files.read files.read.all files.readwrite files.readwrite.all',
            'client_secret' => 'L-47R!]_ay^;4d!1iJ(&UC>wWE}>%Bgm#R&]}R=:!@AXFD+%w&$',
            'service_username' => 'webmsgraph',
        ],
    ],
];
