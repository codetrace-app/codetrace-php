<?php

namespace CodeTrace;

use Monolog\Formatter\NormalizerFormatter;

class CodeTraceFormatter extends NormalizerFormatter
{
    public function format(array $record): array
    {
        if (isset($record['context']['exception']) && $record['context']['exception'] instanceof \Throwable) {
            $record['context']['exception'] = $this->normalizeException($record['context']['exception']);
        }

        return [
            'level' => strtolower($record['level_name']),
            'message' => $record['message'],
            'context' => $record['context'],
        ];
    }
}
