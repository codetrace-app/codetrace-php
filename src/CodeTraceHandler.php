<?php

namespace CodeTrace;

use GuzzleHttp\ClientInterface;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;

class CodeTraceHandler extends AbstractProcessingHandler
{
    protected ClientInterface $client;

    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new CodeTraceFormatter();
    }

    /**
     * @inheritDoc
     */
    protected function write(array $record): void
    {
        $this->client->request('POST', 'reports', [
            'json' => $this->formatter->format($record),
        ]);
    }
}
