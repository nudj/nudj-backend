<?php namespace App\Utility\Transformers;

class ContactTransformer extends Transformer {

    public static $dependencies = [
        'user' => 'user_id'
    ];

    public function transformMap($item, $column) {

        switch($column) {
            case 'id':
                return (string) $item->id;

            case 'alias':
                return (string) $item->alias;

            case 'phone':
                return (string) $item->phone;

            case 'apple_id':
                return (int) $item->apple_id;

            case 'favourite':
                return (bool) $item->favourite;

            case 'mute':
                return (bool) $item->mute;

            case 'user':
                if($item->user) {
                    $tranform = new UserTransformer();
                    return $tranform->transform($item->user);
                }

                return null;
        }

    }

    public function transformCollection($items)
    {
        $groups = array();
        foreach ($items as $item) {
            $letter = mb_substr(mb_strtoupper($item->alias), 0 ,1);
            $groups[$letter][] = $this->transform($item);
        }

        ksort($groups);

        return $groups;
    }

}