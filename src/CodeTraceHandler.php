<?php

namespace CodeTrace;

use GuzzleHttp\ClientInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class CodeTraceHandler extends AbstractProcessingHandler
{
    protected ClientInterface $client;

    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @inheritDoc
     */
    protected function write(LogRecord $record): void
    {
        if (isset($record->context['exception']) && $record->context['exception'] instanceof \Throwable) {
            $context['exception'] = $record->context['exception']->getTraceAsString();
        } else {
            $context = $record->context;
        }

        $json = [
            'level' => strtolower($record->level->getName()),
            'message' => $record->message,
            'context' => $context,
        ];

        $this->client->request('POST', 'reports', [
            'json' => $json,
        ]);
    }
}
