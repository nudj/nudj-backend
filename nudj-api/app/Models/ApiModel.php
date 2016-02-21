<?php namespace App\Models;

/*

	Most of the original models inherited from this class. 
	This made the adoption more difficult as some instructions 
		are standard Laravel ORM and some are in fact defined here, and among the 
		latter few are "Laravel magic" (one of them being Scope), see Laravel Documentation.

	This class essentially defines 
		- Few scopes (shorthands for queries).
		- Few standard methods (which I guess made sense to the original devs).
			Most of them define which fields of the method can be seen from the client.
		- The getConfigItem($item)

*/

use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Util;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;

class ApiModel extends Model
{

    public $selection;
    protected $prefix = null;
    protected $aliases = [];
    protected $dependencies = [];

    public function scopeApi($query)
    {
        $columns = Util::extractParams(Input::get('params'), $this->prefix);

        if (empty($columns))
            $columns = $this->defaultFields;

        array_unshift($columns, $this->primaryKey);

        $columns = array_replace($columns, $this->dependencies);
        $columns = array_intersect($columns, $this->visible);

        return $query->select($columns);
    }

    /* Scopes
   ----------------------------------------------------- */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeMin($query)
    {
        return $query->select($this->primaryKey);
    }

    public function scopeDesc($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function getFields()
    {
        return $this->gettableFields;
    }

    public function getAliases()
    {
        return $this->aliases;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function getDefaultFields()
    {
        return $this->defaultFields;
    }

    public function getDefaultValues()
    {
        $result = [];
        $showing = array_intersect($this->visible, $this->defaultFields);
        foreach ($showing as $field) {
            $result[$field] = $this->$field;
        }

        return $result;
    }

    public function getConfigItem($item) {

    	/*
			This is an interesting use of config files to store models parameters 
			that you would not want to necessarily put into the model's source code. 
    	*/

        if(!isset($this->table))
            throw new ApiException(ApiExceptionType::$MISSING_PROPERTY);

        return Config::get("models.{$this->table}.{$item}");
    }

}