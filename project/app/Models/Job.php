<?php namespace App\Models;

use App\Models\Traits\Indexable;
use App\Utility\Transformers\JobTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;


class Job extends ApiModel
{

    use SoftDeletes, Indexable;

    protected $table = 'jobs';
    protected $visible = ['id', 'title', 'description', 'salary', 'status', 'bonus', 'user_id'];

    protected $gettableFields = ['title', 'description', 'salary', 'status', 'bonus', 'skills', 'user', 'liked'];
    protected $defaultFields = ['title', 'user'];

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

    public function likes()
    {
        return $this->belongsToMany('App\Models\User', 'job_likes');
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

        if (isset($input['active'])) {
            $this->active = (bool)$input['active'];
            $searchEngineUpdate['active'] = (bool)$input['active'];
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
        $job->user_id = (int) $userId;
        $job->title = (string)$input['title'];
        $job->description = (string)$input['description'];
        $job->active = true;

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
            $job->likes()->sync([$userId], false);
        else
            $job->likes()->detach($userId);

        return true;
    }


    /* Checks
   ----------------------------------------------------- */

    public static function findIfOwnedBy($jobId, $ownerId)
    {
        $job = Job::with('user')->find($jobId);

        if (isset($job->user->id) && $ownerId == $job->user->id)
            return $job;

        return null;
    }

    public function isLikedBy()
    {
        return true;
    }


}


