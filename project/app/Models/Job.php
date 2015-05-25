<?php namespace App\Models;

use App\Models\Traits\Indexable;
use App\Utility\Transformers\JobTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;


class Job extends ApiModel
{

    use SoftDeletes, Indexable;

    protected $table = 'jobs';
    protected $visible = array('id', 'title', 'description', 'salary', 'status', 'bonus', 'user_id');

    protected $gettableFields = array('title', 'description', 'salary', 'status', 'bonus', 'skills', 'user');
    protected $defaultFields = array('title', 'user');

    protected $prefix = 'job.';

    public function __construct()
    {
        $this->dependencies = JobTransformer::$dependencies;
    }

    /* Relations
    ----------------------------------------------------- */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill', 'job_skill');
    }

    public function favourites()
    {
        return $this->belongsToMany('App\Models\User', 'job_favourites');
    }


    /* CRUD
   ----------------------------------------------------- */

    public function edit($input)
    {
        $searchEngineUpdate = [];

        if (isset($input['title'])) {
            $this->title = (string)$input['title'];
            $searchEngineUpdate['title'] = (string)$input['title'];
        }

        if (isset($input['description'])) {
            $this->description = (string)$input['description'];
            $searchEngineUpdate['description'] = (string)$input['description'];
        }

        if (isset($input['bonus'])) {
            $this->bonus = (double)$input['bonus'];
            $searchEngineUpdate['bonus'] = (double)$input['bonus'];
        }

        if (isset($input['salary'])) {
            $this->salary = (string)$input['salary'];
        }

        if (isset($input['status'])) {
            $this->status = (string)$input['status'];
        }

        if (isset($input['skills'])) {
            $this->syncSkills($input['skills']);
            $searchEngineUpdate['skills'] = array_column($this->skills->toArray(), 'name');
        }

        $saved = $this->save();

        if ($saved && $searchEngineUpdate) {
            $this->updateToIndex('job', $this->id, $searchEngineUpdate);
        }

        return $saved;
    }

    private function syncSkills($skillList)
    {
        $ids = Skill::addMissing($skillList);
        $this->skills()->sync($ids);

        return $ids;
    }

    public static function add($userId, $input)
    {

        $job = new Job;
        $job->user_id = $userId;
        $job->title = (string)$input['title'];
        $job->description = (string)$input['description'];

        if (isset($input['salary']))
            $job->salary = (string)$input['salary'];

        if (isset($input['status']))
            $job->status = (string)$input['status'];

        if (isset($input['bonus']))
            $job->bonus = (string)$input['bonus'];

        $saved = $job->save();

        if (isset($input['skills']))
            $job->syncSkills($input['skills']);

        if ($saved) {
            $job->addToIndex('job', $job->id, [
                'title' => $job->title,
                'description' => $job->description,
                'bonus' => $job->bonus,
                'skills' => array_column($job->skills->toArray(), 'name'),
                'user_id' => $job->user_id
            ]);
        }

        return $job;
    }

    public static function like($id, $userId, $remove = false)
    {

        $job = self::find($id);

        if (!$job)
            return false;

        if (!$remove)
            $job->favourites()->sync([$userId], false);
        else
            $job->favourites()->detach($id);

        return true;
    }

    public static function findIfOwnedBy($jobId, $ownerId)
    {
        $job = Job::with('user')->find($jobId);

        if (isset($job->user->id) && $ownerId == $job->user->id)
            return $job;

        return null;
    }


}


