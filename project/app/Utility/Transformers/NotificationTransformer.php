<?php namespace App\Utility\Transformers;


class NotificationTransformer extends Transformer
{

    public static $dependencies = [
        'type' => 'type_id',
        'sender' => 'sender_id',
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
                return json_decode($item->meta);

            case 'read':
                return (bool)$item->read;

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