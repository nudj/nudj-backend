<?php namespace App\Utility\Transformers;

use App\Models\Chat;
use App\Utility\Facades\Shield;

class UserTransformer extends Transformer
{

    public static $aliases = [
        'sender' => 'user',
        'candidate' => 'user',
        'participant' => 'user',
    ];

    public static $dependencies = [
        'facebook' => 'facebook_token'
    ];

    public function transformMap($item, $column)
    {

        switch ($column) {
            case 'id':
                return (string)$item->id;

            case 'phone':
                return (string)$item->phone;

            case 'email':
                return (string)$item->email;

            case 'name':
                return (string)$item->name;

            case 'position':
                return (string)$item->position;

            case 'about':
                return (string)$item->about;

            case 'address':
                return (string)$item->address;

            case 'company':
                return (string)$item->company;

            case 'status':
                return (int)$item->status;

            case 'completed':
                return (bool)$item->completed;

            case 'facebook':
                return (bool)$item->facebook_token;

            case 'favourite':
                return (bool) $item->isFavouritedBy(Shield::getUserId());

            case 'settings':
                return json_decode($item->settings);

            case 'image':
                $images = $item->getCloudImageUrls($item->id, json_decode($item->image), $this->sizes);
                return $images;

            case 'skills':
                $tranform = new SkillTransformer();
                return $tranform->transformCollection($item->skills);

            case 'contacts':
                $tranform = new ContactTransformer();
                return $tranform->transformCollection($item->contacts);

            case 'contact':
                $contact = $item->getBelongingContact(Shield::getUserId());

                if (!$contact)
                    return null;

                $tranform = new ContactTransformer();
                return $tranform->transform($contact);

            case 'counters':
                $counters = [
                  'saved_jobs' => $item->likes->count(),
                  'posted_jobs' => $item->jobs->count(),
                  'archived_chats' => Chat::mine($item->id)->archive($item->id)->count(),
                ];
                return $counters;
        }

    }

}