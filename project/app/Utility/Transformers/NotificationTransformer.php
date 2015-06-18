<?php namespace App\Utility\Transformers;


class NotificationTransformer extends Transformer {

    public static $dependencies = [
        'type' => 'type_id',
        'message' => 'meta',
    ];

    public function transformMap($item, $column) {

        switch($column) {

            case 'id':
                return (int) $item->id;

            case 'type':
                return (int) $item->type_id;

            case 'message':
                return $item->getMessage();

            case 'read':
                return (bool) $item->read;

        }

    }

}