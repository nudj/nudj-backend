<?php namespace App\Utility\Transformers;

use Log;
use App\NSX300\NSX300_Jobs;

class NotificationTransformer extends Transformer
{

    public static $dependencies = [
        'type' => 'type_id',
        'sender' => 'sender_id',
        'created' => 'created_at',
        'message' => 'meta',
    ];

    public function transformMap($item, $column)
    {

        switch ($column) {

            case 'id':
                return (int)$item->id;

            case 'type':
                return (int)$item->type_id;

            case 'meta':
                $meta = json_decode($item->meta,true);
                $jobid = $meta["job_id"];
                $meta['job_bonus_currency'] = NSX300_Jobs::get_currency_bonus_for_job($jobid);
                return $meta;

            case 'read':
                return (bool)$item->read;

            case 'created':
                return strtotime($item->created_at);

            case 'message':
                $meta = json_decode($item->meta, true);

                if (is_array($meta))
                    return $item->getMessage($meta);
                else
                    return '';

            case 'sender':
                $tranform = new UserTransformer();
                return $tranform->transform($item->sender);

        }

    }

}