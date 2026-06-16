<?php

use Illuminate\Support\Str;

$databaseUrl = env('DATABASE_URL');
$parsedUrl = $databaseUrl ? parse_url($databaseUrl) : [];
$query = [];

if (! empty($parsedUrl['query'])) {
    parse_str($parsedUrl['query'], $query);
}

return [
    'default' => env('DB_CONNECTION', 'pgsql'),
    'connections' => [
        'pgsql' => [
            'driver' => 'pgsql',
            'url' => $databaseUrl,
            'host' => $parsedUrl['host'] ?? env('DB_HOST', '127.0.0.1'),
            'port' => $parsedUrl['port'] ?? env('DB_PORT', '5432'),
            'database' => isset($parsedUrl['path']) ? ltrim($parsedUrl['path'], '/') : env('DB_DATABASE', 'laravel'),
            'username' => $parsedUrl['user'] ?? env('DB_USERNAME', 'root'),
            'password' => $parsedUrl['pass'] ?? env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => $query['sslmode'] ?? env('DB_SSLMODE', 'require'),
            'options' => extension_loaded('pdo_pgsql') ? [
                PDO::ATTR_EMULATE_PREPARES => true,
            ] : [],
        ],
    ],
    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],
    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),
        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],
    ],
];
