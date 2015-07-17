<?php namespace App\Models;

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

    public function scopeMin($query)
    {
        return $query->select($this->primaryKey);
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

        if(!isset($this->table))
            throw new ApiException(ApiExceptionType::$MISSING_PROPERTY);

        return Config::get("models.{$this->table}.{$item}");
    }


}