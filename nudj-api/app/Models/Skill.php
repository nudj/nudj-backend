<?php namespace App\Models;

use App\Models\Traits\Indexable;

class Skill extends ApiModel
{

    use Indexable;

    public $timestamps = false;

    protected $table = 'skills';
    protected $visible = ['id', 'name'];
    protected $fillable = ['name'];

    protected $gettableFields = ['name'];
    protected $defaultFields = ['name'];

    protected $prefix = 'skill.';

    /* Relations
    ----------------------------------------------------- */
    public function job()
    {
        return $this->belongsToMany('App\Models\Job', 'job_skill');
    }

    public function user()
    {
        return $this->belongsToMany('App\Models\User', 'user_skill');
    }

    /* GET
    ----------------------------------------------------- */
    public function suggest($term)
    {
        return $this->suggestFromIndex($term, 'skill', 'name');
    }

    /* CRUD
    ----------------------------------------------------- */

    public static function addMissing($list)
    {
        $ids = [];
        foreach ($list as $name) {

            $skill = self::firstOrNew(['name' => $name]);

            if (!isset($skill->id)) {
                $saved = $skill->save();

                if ($saved) {
                    $skill->addToIndex('skill', $skill->id, ['name' => $skill->name]);
                }
            }

            $ids[] = $skill->id;
        }

        return $ids;

    }
}
