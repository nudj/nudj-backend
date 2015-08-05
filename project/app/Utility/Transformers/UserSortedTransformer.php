<?php namespace App\Utility\Transformers;



class  UserSortedTransformer  extends  UserTransformer
{


    public function transformCollection($items)
    {

        $groups = array();
        foreach ($items as $item) {
            $letter = mb_substr(mb_strtoupper($item->name), 0 ,1);
            $groups[$letter][] = $this->transform($item);
        }

        ksort($groups);

        return $groups;
    }

}