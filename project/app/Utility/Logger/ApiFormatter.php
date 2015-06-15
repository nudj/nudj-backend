<?php


namespace App\Utility\Logger;


use Monolog\Formatter\FormatterInterface;

class ApiFormatter implements FormatterInterface
{

    public function format(array $record)
    {
        $formatted = [];

        if (isset($record['context']['id'])) {
            $formatted['id'] = $record['context']['id'];
        }

        if (isset($record['context']['timestamp'])) {
            $formatted['timestamp'] = $record['context']['timestamp'];
        }

        if (isset($record['context']['type'])) {
            $formatted['type'] = $record['context']['type'];
        }

        if (isset($record['context']['endpoint'])) {
            $formatted['endpoint'] = $record['context']['endpoint'];
        }

        if (isset($record['context']['get'])) {
            $formatted['get'] = $record['context']['get'];
        }

        if (isset($record['context']['post'])) {
            $formatted['post'] = $record['context']['post'];
        }

        if (isset($record['context']['token'])) {
            $formatted['token'] = $record['context']['token'];
        }

        if (isset($record['context']['response'])) {
            $formatted['response'] = $record['context']['response'];
        }

        if (isset($record['context']['headers'])) {
            $formatted['headers'] = $record['context']['headers'];
        }

        return json_encode($formatted) .  "\n";
    }


    public function formatBatch(array $records)
    {
        return json_encode($records);
    }


}