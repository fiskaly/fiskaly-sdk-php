<?php

require __DIR__ . '/../vendor/autoload.php';

use FiskalyClient\FiskalyClient;

/**
 * Example environment variables
 * In real project please use https://github.com/vlucas/phpdotenv
 */
if (!file_exists(__DIR__ . '../env.php')) {
    require_once(__DIR__ . '/../env.php');
} else {
    exit('env.php file does not exist');
}

/** initialize the fiskaly API client class using credentials */
try {
    $client = FiskalyClient::createUsingCredentials($_ENV["FISKALY_SERVICE_URL"], $_ENV["FISKALY_API_KEY"], $_ENV["FISKALY_API_SECRET"], 'https://kassensichv.io/api/v1');
} catch (Exception $e) {
    exit($e);
}

/**
 * get version of client and SMAERS
 */
try {
    $version = $client->getVersion();
    echo "Version: ", $version, "\n\n";
} catch (Exception $e) {
    exit($e);
}

/**
 * get config of client - before configure should be null
 */
try {
    $config = $client->getConfig();
    echo "Config Before Update: ", $config, "\n\n";
} catch (Exception $e) {
    exit($e);
}

/**
 * configure client
 */
try {
    $config_params = [
        'debug_level' => 4,
        'debug_file' => __DIR__ . '/../fiskaly.log',
        'client_timeout' =>  5000,
        'smaers_timeout' =>  2000,
    ];
    $config = $client->configure($config_params);
    echo "Configuration: ", $config, "\n\n";
} catch (Exception $e) {
    exit($e);
}

/**
 * get config of client - after configure should be instance of ClientConfiguration class
 */
try {
    $config = $client->getConfig();
    echo "Config After Update: ", $config, "\n\n";
} catch (Exception $e) {
    exit($e);
}


/**
 * request example
 */
try {
    $response = $client->request(
        'PUT',
        '/tss/ecb75169-680f-48d1-93b2-52cc10abb9f/tx/9cbe6566-e24c-42ac-97fe-6a0112fb3c6',
        ["last_revision" => "0"],
        ["Content-Type" => "application/json"],
        'eyJzdGF0ZSI6ICJBQ1RJVkUiLCJjbGllbnRfaWQiOiAiYTYyNzgwYjAtMTFiYi00MThhLTk3MzYtZjQ3Y2E5NzVlNTE1In0='
    );
    echo "Request response: ", $response, "\n\n";
} catch (Exception $e) {
    exit($e);
}
