<?php namespace App\Utility\Transformers;

use App\Utility\Facades\Shield;

class ChatTransformer extends Transformer
{

    public static $dependencies = [
        'job' => 'job_id',
        'created' => 'created_at',
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

            case 'created':
                return strtotime($item->created_at);

            case 'participants':
                if ($item->participants) {
                    $tranform = new UserTransformer();
                    return $tranform->transformCollection($item->participants);
                }
                return null;

            case 'muted':
                $me = null;

                foreach($item->participants as $participant) {
                    if($participant->id == Shield::getUserId()) {
                        $me = $participant;
                    }
                }

                return  isset($me->pivot->mute) ? (bool) $me->pivot->mute : (bool) false;
        }

    }

}