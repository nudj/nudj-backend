<?php namespace App\Utility\Transformers;


class ChatTransformer extends Transformer
{

    public static $dependencies = [
        'job' => 'job_id'
    ];

    public function transformMap($item, $column)
    {

        switch ($column) {
            case 'id':
                return (string)$item->id;

            case 'job':
                if ($item->job) {
                    $tranform = new JobTransformer();
                    return $tranform->transform($item->job);
                }
                return null;

        }

    }



}