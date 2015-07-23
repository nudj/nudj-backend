<?php


namespace App\Utility\Logger;


use Monolog\Formatter\FormatterInterface;

class ApiMongoFormatter implements FormatterInterface
{

    public function format(array $record)
    {
        $formatted = [];

        if (isset($record['context']['id'])) {
            $formatted['id'] = $record['context']['id'];
        }

        if (isset($record['context']['type'])) {
            $formatted['type'] = $record['context']['type'];
        }

        if (isset($record['context']['from'])) {
            $formatted['from'] = $record['context']['from'];
        }

        if (isset($record['context']['endpoint'])) {
            $formatted['endpoint'] = $record['context']['endpoint'];
        }

        if (isset($record['context']['token'])) {
            $formatted['token'] = $record['context']['token'];
        }

        if (isset($record['context']['get'])) {
            $formatted['get'] = $record['context']['get'];
        }

        if (isset($record['context']['post'])) {
            $formatted['post'] = $record['context']['post'];
        }

        if (isset($record['context']['headers'])) {
            $formatted['headers'] = $record['context']['headers'];
        }

        return $formatted;
    }


    public function formatBatch(array $records)
    {
        $formatted = [];

        foreach ($records as $record) {
            $formatted[] = $this->format($record);
        }

        return $formatted;
    }


}