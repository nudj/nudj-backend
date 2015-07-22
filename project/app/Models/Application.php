<?php namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;


class Application extends ApiModel
{

    use SoftDeletes;


    protected $table = 'applications';
    protected $visible = ['id', 'job_id', 'candidate'];

    protected $gettableFields = ['id', 'job_id', 'candidate'];
    protected $defaultFields = ['id', 'job_id', 'candidate'];

    protected $prefix = 'application.';


    /* Relations
    ----------------------------------------------------- */
    public function job()
    {
        return $this->belongsTo('App\Models\Job', 'job_id');
    }

    public function candidate()
    {
        return $this->belongsTo('App\Models\User', 'candidate_id');
    }


    /* Actions
    ----------------------------------------------------- */


    public static function applyForJob($userId, $jobId, $referrerId = null)
    {

        //@TODO check for previous application

        $job = Job::with('user')->findOrFail($jobId);
        $candidate = User::findoRFail($userId);

        // Create new application
        $application = new Application();
        $application->job_id = $jobId;
        $application->candidate_id = $userId;
        if($referrerId)
            $application->referrer_id = $referrerId;
        $application->save();


        // Create notification
        $meta = [
            'job_id' => $job->id,
            'job_title' => $job->title,
            'position' => $job->title,
            'candidate' => $candidate->name
        ];

        $referrer = null;
        if ($referrerId) {
            $referrer = User::findoRFail($referrerId);
        }

        Notification::createAppApplicationNotification($job->user_id, $userId, $meta, $referrer);

    }


}


