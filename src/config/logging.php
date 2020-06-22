<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        'syncAmbientes' => [
            'driver' => 'single',
            'path' => storage_path('logs/sync_ambientes.log')
        ],

        'syncOperacoes' => [
            'driver' => 'single',
            'path' => storage_path('logs/sync_operacoes.log')
        ],

        'syncUnidades' => [
            'driver' => 'single',
            'path' => storage_path('logs/sync_unidades.log')
        ],

        'syncProdutos' => [
            'driver' => 'single',
            'path' => storage_path('logs/sync_produtos.log')
        ],

        'syncAgentes' => [
            'driver' => 'single',
            'path' => storage_path('logs/sync_agentes.log')
        ],

        'syncUniversoUsuario' => [
            'driver' => 'single',
            'path' => storage_path('logs/sync_universo-usuarios.log')
        ],

        'syncUniversoUsuariosAgente' => [
            'driver' => 'single',
            'path' => storage_path('logs/sync_universo-usuarios-agentes.log')
        ],

        'syncUniversoUsuariosUnidade' => [
            'driver' => 'single',
            'path' => storage_path('logs/sync_universo-usuarios-unidades.log')
        ],
    ],
];
