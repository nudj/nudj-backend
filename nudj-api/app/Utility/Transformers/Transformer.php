<?php namespace App\Utility\Transformers;

use App\Utility\Util;
use Illuminate\Support\Facades\Input;

abstract class Transformer
{

    protected $sizes;

    public abstract function transformMap($item, $column);

    public function transformCollection($items)
    {
        if(!$items)
            return [];

        return array_map([$this, 'transform'], $items->all());
    }
    
    public function transform($item) {

        $columns = Util::extractParams(Input::get('params'), $item->getPrefix(), $item->getAliases());

        $columns = array_intersect($columns, $item->getFields());
        if(empty($columns))
            $columns = $item->getDefaultFields();

        array_unshift($columns, $item->getKeyName());

        if(Input::has('sizes'))
            $this->sizes = Util::extractParams(Input::get('sizes'), $item->getPrefix());


        $response = [];
        foreach ($columns as $column) {
           $response[$column] = $this->transformMap($item, $column);
        }

        return $response;
    }

}