<?php namespace App\Utility\Transformers;

use App\Models\Referral;
use App\Utility\Facades\Shield;
use Carbon\Carbon;

class JobTransformer extends Transformer {

    public static $dependencies = [
        'user' => 'user_id',
        'created' => 'created_at',
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

            case 'salary_amount':
                return (float) $item->salary2;

            case 'salary_currency':
                return (float) $item->salary2_currency;

            case 'company':
                return (string) $item->company;

            case 'location':
                return (string) $item->location;

            case 'active':
                return (bool) $item->active;

            case 'bonus':
                return (double) $item->bonus;

            case 'bonus_currency':
                return (double) $item->bonus_currency;

            case 'created':
                return (string) Carbon::createFromTimestamp(strtotime($item->created_at))->diffForHumans();

            case 'liked':
                return  (bool) $item->likes->contains(Shield::getUserId());

            case 'applied':
                $referrer = Referral::select('id')
                    ->where('job_id', '=', $item->job_id)
                    ->where('referrer_id', '=', Shield::getUserId())
                    ->count();
                return  (bool) $referrer;

            case 'user':
                $tranform = new UserTransformer();
                return $tranform->transform($item->user);

            case 'skills':
                $tranform = new SkillTransformer();
                return $tranform->transformCollection($item->skills);

        }

    }

}