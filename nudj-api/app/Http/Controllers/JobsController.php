<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Http\Requests;

use App\Models\Job;
use App\Models\JobsBlocked;
use App\Models\User;

use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\Snafu;
use App\Utility\Transformers\JobTransformer;

use Illuminate\Support\Facades\Input;

use Log;

class JobsController extends ApiController
{

    public function index($filter = null)
    {

        $me = Shield::getUserId();

        switch ($filter) {
            case 'mine' :
                $items = Job::mine($me)
                    ->whereNotIn('id', JobsBlocked::get_blocked_jobids_for_primary_user($me))
                    ->active()
                    ->api()
                    ->desc()
                    ->paginate($this->limit);
                break;
            case 'liked' :
                $items = Job::liked($me)
                    ->whereNotIn('id', JobsBlocked::get_blocked_jobids_for_primary_user($me))
                    ->active()
                    ->api()
                    ->desc()
                    ->paginate($this->limit);
                break;
            case 'available' :
                $items = Job::available($me)
                    ->whereNotIn('id', JobsBlocked::get_blocked_jobids_for_primary_user($me))
                    ->active()
                    ->api()
                    ->desc()
                    ->paginate($this->limit);
                break;
            default:
                throw new ApiException(ApiExceptionType::$INVALID_ENDPOINT);
        }

        return $this->respondWithPagination($items, new JobTransformer());
    }

    public function show($id)
    {
        $item = Job::api()->find($id);

        if (!$item)
            throw new ApiException(ApiExceptionType::$NOT_FOUND);

        return $this->respondWithItem($item, new JobTransformer());
    }

    public function store(CreateJobRequest $request)
    {
        $job = Job::add(Shield::getUserId(), $request->all());

        return $this->respondWithId($job->id);
    }

    public function update($id)
    {
        $job = Job::findIfOwnedBy($id, Shield::getUserId());

        if (!$job)
            throw new ApiException(ApiExceptionType::$NOT_FOUND);

        $status = $job->edit(Input::all());

        return $this->respondWithStatus($status);
    }

    public function search($term = null)
    {
        if(!$term)
            throw new ApiException(ApiExceptionType::$INVALID_INPUT);

        $job = new Job();
        $items = $job->search($term);

        $me = Shield::getUserId(); // id of the current user
        $items = JobsController::select_user_s_subset_of_non_blocked_jobs_return_array($me,$items);

        return $this->respondWithItems($items, new JobTransformer());
    }

    public function destroy($id)
    {
        $job = Job::findIfOwnedBy($id, Shield::getUserId());

        if (!$job)
            throw new ApiException(ApiExceptionType::$NOT_FOUND);

        $status = $job->delete();

        return $this->respondWithStatus($status);
    }

    public function like($id)
    {
        // Causes the current user to like the job.
        return $this->respondWithStatus(Job::like($id, Shield::getUserId()));
    }

    public function unlike($id)
    {
        // Causes the current user to unlike the job.
        return $this->respondWithStatus(Job::like($id, Shield::getUserId(), true));
    }

    public function blockjob($reportedjobid)
    {
    	$me = Shield::getUserId();
    	$myself = User::min()->findOrFail($me);
    	$myjobids = [];
    	foreach($myself->jobs()->get() as $job){
    		$myjobids[] = $job->id;
    	}

        if(in_array($reportedjobid,$myjobids)){
            throw new ApiException(ApiExceptionType::$BAD_REQUEST);
        }    	

    	JobsBlocked::block_job($me,$reportedjobid);
    	return $this->respondWithStatus(true);
    }

    public static function select_user_s_subset_of_non_blocked_jobs_return_array($primary_userid,$jobs){

        /*
            This function was introduced because the patterns of filtering some jobs out from a collection would be used a lot
            ( Side effect of, introducing Job blocking )
            Written as a static function of the class, because we might have to move it somewhere else at some point. 
        */

        // Unfortunately PHP doesn't have an array select function 

        $jobids = JobsBlocked::get_blocked_jobids_for_primary_user($primary_userid);
        $newjobs = [];
        foreach($jobs as $job){
            if(!in_array($job->id,$jobids)){
                $newjobs[] = $job;
            }
        }

        return $newjobs;

    }

}
