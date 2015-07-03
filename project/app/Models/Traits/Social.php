<?php

namespace App\Models\Traits;


trait Social {

    public function importFromFacebook($incomingData)
    {

        $import = [];

        if(!$this->name && isset($incomingData->name))
            $import['name'] = $incomingData->name;

        if(!$this->email && isset($incomingData->email))
            $import['email'] = $incomingData->email;

        if(!$this->location && isset($incomingData->location->name))
            $import['location'] = $incomingData->location->name;

        if(!$this->image && isset($incomingData->picture->url))
            $import['image'] = $incomingData->picture->url;

        if(!$this->about && isset($incomingData->bio))
            $import['about'] = $incomingData->bio;

        $this->edit($import);
    }

    public function importFromLinkedIn($incomingData)
    {

        $import = [];

        if(!$this->name && (isset($incomingData->firstName) || isset($incomingData->lastName)))
            $import['name'] = isset($incomingData->firstName) ? $incomingData->firstName : '' . ' ' . isset($incomingData->lastName) ? $incomingData->lastName : '';

        if(!$this->skills && isset($incomingData->skills->values)) {
            $skillList = [];
            foreach ($incomingData->skills->values as $skill) {
                $skillList[] = $skill->skill->name;
            }
            $import['skills'] = $skillList;
        }

        print_r($incomingData);
        print_r($import);

//        $this->edit($import);
    }

}