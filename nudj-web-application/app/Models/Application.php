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

    public static function applyForJob($userId, $jobId, $referrerId = null, $web = false)
    {

        $application = self::select('id')
            ->where('candidate_id', '=', $userId)
            ->where('job_id', '=', $jobId)
            ->count();

        if ($application)
            return true;

        $job = Job::with('user')->findOrFail($jobId);
        $candidate = User::findoRFail($userId);

        // Create new application
        $application = new Application();
        $application->job_id = $jobId;
        $application->candidate_id = $userId;

        if ($referrerId)
            $application->referrer_id = $referrerId;

        $application->save();

        // Create notification
        $meta = [
            'job_id' => $job->id,
            'job_title' => $job->title,
            'job_bonus' => $job->bonus,
            'position' => $job->title,
            'candidate' => $candidate->name,
	        'phone' => $candidate->phone
        ];

        $referrer = null;
        if ($referrerId) {
            $referrer = User::findoRFail($referrerId);
        }

        if (!$web)
            Notification::appApllication($job->user_id, $userId, $meta, $referrer);
        else
            Notification::webApllication($job->user_id, $userId, $meta, $referrer);

        return true;
    }

}


