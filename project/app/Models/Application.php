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


    public static function applyForJob($userId, $jobId)
    {

        $job = Job::with('user')->findOrFail($jobId);

        $application = new Application();
        $application->job_id = $jobId;
        $application->candidate_id = $userId;
        $application->save();

        // Create notification
        Notification::createAppApplicationNotification($job->user_id, $userId, [
            'job_id' => $job->id,
            'job_title' => $job->title,
            'referrer_id' => null,
        ]);

    }


}


