<?php

use Symfony\Component\Dotenv\Dotenv;

$dir = __DIR__;

require "{$dir}/vendor/autoload.php";

$dev = [
            'adapter' => 'pgsql',
            'host' => getenv('POSTGRES_HOST'),
            'name' => getenv('POSTGRES_DB'),
            'user' => getenv('POSTGRES_USER'),
            'pass' => getenv('POSTGRES_PASSWORD'),
            'port' => getenv('POSTGRES_PORT'),
            'charset' => getenv('POSTGRES_CHARSET'),
];

$test = [
    ...$dev,
    'name' => getenv('POSTGRES_DB_TEST')
];

$production = [
    'dsn' => getenv('DATABASE_URL')
];

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => $production,
        'development' => $dev,
        'test' => $test
    ],
    'version_order' => 'creation'
];
