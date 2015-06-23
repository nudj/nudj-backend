<?php namespace App\Models;


class Country extends ApiModel
{
    public $timestamps = false;
    protected $table = 'countries';


    public function scopeWeb($query)
    {
        return $query->select(['id', 'name', 'code']);
    }
}
