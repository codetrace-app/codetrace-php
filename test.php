<?php

require __DIR__ . '/vendor/autoload.php';

$client = new \GuzzleHttp\Client([
    'base_uri' => 'http://codetrace.test/api/',
    'query' => [
        'api_token' => 'MlsQtlaQdjlXFfqXHMgwAXyNdny2NHoBhrVE4Ebna1i4oRsCw3VTej4R6dx5yPVg',
    ],
]);

//$client->request('POST', 'reports', [
//    'json' => [
//        'level' => 'debug',
//        'message' => 'Send via CodeTrace PHP',
//        'context' => [
//            'name' => 'Quynh',
//            'age' => 27,
//        ],
//    ],
//]);

$handler = new \CodeTrace\CodeTraceHandler();
$handler->setClient($client);

$logger = new \Monolog\Logger('CodeTrace');
$logger->pushHandler($handler);

//$logger->info('I am building code trace. A simple debug tool for developers.', [
//    'name' => 'Quynh',
//    'age' => 27,
//]);

try {
    throw new \RuntimeException('Something went wrong');
} catch (\Throwable $e) {
    $logger->error($e->getMessage(), ['exception' => $e]);
}
