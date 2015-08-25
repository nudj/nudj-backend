<?php

namespace App\Models\Traits;


use App\Utility\Snafu;
use League\Flysystem\Exception;

trait Social {

    public function importFromFacebook($incomingData)
    {
        $import = [];


        if(!$this->name && isset($incomingData->name))
            $import['name'] = $incomingData->name;

        if(!$this->email && isset($incomingData->email))
            $import['email'] = $incomingData->email;

        if(!$this->location && isset($incomingData->location->name))
            $import['address'] = $incomingData->location->name;

        if(!$this->image && isset($incomingData->picture->data->url))
            $import['image'] = $incomingData->picture->data->url;

        if(!$this->about && isset($incomingData->bio))
            $import['about'] = $incomingData->bio;

        if(isset($incomingData->work) && !empty($incomingData->work)) {

            $workDetails = current($incomingData->work);

            if(!$this->company)
                $import['company'] = $workDetails->employer->name;

            if(!$this->position)
                $import['position'] = $workDetails->position->name;
        }

        $this->edit($import);
    }

    public function importFromLinkedIn($incomingData)
    {

        $import = [];

        if(!$this->name && (isset($incomingData->firstName) || isset($incomingData->lastName)))
            $import['name'] = isset($incomingData->firstName) ? $incomingData->firstName : '' . ' ' . isset($incomingData->lastName) ? $incomingData->lastName : '';

        if(!$this->email && isset($incomingData->emailAddress))
            $import['email'] = $incomingData->emailAddress;


        if(isset($incomingData->skills->values)) {
            $skillList = [];
            foreach ($incomingData->skills->values as $skill) {
                $skillList[] = $skill->skill->name;
            }
            $import['skills'] = $skillList;
        }

        $this->edit($import);
    }

}