<?php namespace App\Utility\Transformers;


use App\Utility\Facades\Shield;

class UserTransformer extends Transformer
{


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

            case 'status':
                return (int)$item->status;

            case 'completed':
                return (bool)$item->completed;

            case 'favourite':
                return (bool) $item->favourites->contains(Shield::getUserId());

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
                $contact = $item->getBelongingContact($this->user->id);

                if (!$contact)
                    return null;

                $tranform = new ContactTransformer();
                return $tranform->transform($contact);

        }

    }

}