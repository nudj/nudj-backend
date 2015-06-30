<?php namespace App\Utility\Transformers;


use App\Utility\Facades\Shield;

class JobTransformer extends Transformer {

    public static $dependencies = [
        'user' => 'user_id'
    ];

    public function transformMap($item, $column) {

        switch($column) {
            case 'id':
                return (string) $item->id;

            case 'title':
                return (string) $item->title;

            case 'description':
                return (string) $item->description;

            case 'salary':
                return (string) $item->salary;

            case 'status':
                return (bool) $item->status;

            case 'bonus':
                return (double) $item->bonus;

            case 'liked':
                return  (bool) $item->likes->contains(Shield::getUserId());

            case 'user':
                $tranform = new UserTransformer();
                return $tranform->transform($item->user);

            case 'skills':
                $tranform = new SkillTransformer();
                return $tranform->transformCollection($item->skills);



        }

    }

}