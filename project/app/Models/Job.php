<?php namespace App\Models;

use App\Models\Traits\Indexable;
use App\Utility\Transformers\JobTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Job extends ApiModel
{

    use SoftDeletes, Indexable;

    protected $table = 'jobs';
    protected $visible = ['id', 'title', 'description', 'salary', 'active', 'bonus', 'company', 'location', 'user_id', 'created_at'];

    protected $gettableFields = ['title', 'description', 'salary', 'active', 'bonus', 'company', 'location', 'skills', 'user', 'liked', 'applied', 'created'];
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


    /* Scopes
   ----------------------------------------------------- */
    public function scopeMine($query, $userId = null)
    {
        return $query->where('user_id', '=', $userId);
    }

    public function scopeLiked($query, $userId = null)
    {
        return $query->whereHas('likes', function($q) use ($userId)
        {
            $q->where('job_likes.user_id', '=', $userId);
        });
    }

    public function scopeAvailable($query, $userId = null)
    {
        $contacts = DB::table('contacts')
            ->select('user_id')
            ->where('contact_of', '=', $userId)
            ->whereNotNull('user_id')
            ->get();



        $ids = [$userId];
        foreach($contacts as $contact)
            $ids[] = $contact->user_id;


        if(isset($_GET['debug']) && $_GET['debug'] = 'contacts')
            print_r($ids);

        return $query->whereIn('user_id', $ids);
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

        if (isset($input['active'])) {
            $this->active = (bool)$input['active'];
            $searchEngineUpdate['active'] = (bool)$input['active'];
        }

        if (isset($input['bonus'])) {
            $this->bonus = (double)$input['bonus'];
            $searchEngineUpdate['bonus'] = (double)$input['bonus'];
        }

        if (isset($input['location'])) {
            $this->location = (string)$input['location'];
        }

        if (isset($input['company'])) {
            $this->company = (string)$input['company'];
        }

        if (isset($input['salary'])) {
            $this->salary = (string)$input['salary'];
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
        $job->user_id = (int) $userId;
        $job->title = (string)$input['title'];
        $job->description = (string)$input['description'];
        $job->active = true;

        if (isset($input['bonus'])) {
            $job->bonus = (double)$input['bonus'];
            $searchEngineUpdate['bonus'] = (double)$input['bonus'];
        }

        if (isset($input['location'])) {
            $job->location = (string)$input['location'];
        }

        if (isset($input['company'])) {
            $job->company = (string)$input['company'];
        }

        if (isset($input['salary'])) {
            $job->salary = (string)$input['salary'];
        }

        $saved = $job->save();

        if (isset($input['skills'])) {
            $job->syncSkills($input['skills']);
            $searchEngineUpdate['skills'] = array_column($job->skills->toArray(), 'name');
        }

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


