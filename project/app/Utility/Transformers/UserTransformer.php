<?php namespace App\Utility\Transformers;


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

            case 'address':
                return (string)$item->address;

            case 'status':
                return (int) $item->status;

            case 'completed':
                return (bool)$item->completed;

            case 'image':
                $images = $item->getImageUrls($item->id, json_decode($item->image), $this->sizes);
                return $images;

            case 'skills':
                $tranform = new SkillTransformer();
                return $tranform->transformCollection($item->skills);

            case 'contacts':
                $tranform = new ContactTransformer();
                return $tranform->transformCollection($item->contacts);

        }

    }

}