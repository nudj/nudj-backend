<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Http\Requests;

use App\Models\Job;
use App\Models\BlockJob;

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
                $items = Job::mine($me)->active()->api()->desc()->paginate($this->limit);
                break;
            case 'liked' :
                $items = Job::liked($me)->active()->api()->desc()->paginate($this->limit);
                break;
            case 'available' :
                $items = Job::available($me)->active()->api()->desc()->paginate($this->limit);
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

        // ------------------------------------------------------------------
        // We need to filter away the jobs that are in the users's block list
        // This mark: 5758e0e7-fb80-4114-93b4-fbb809dbf6ba , corresponds to everywhere the same pattern has been used
        // Unfortunately PHP doesn't have an array select function 
        $me = Shield::getUserId(); // id of the current user
        $jobids = BlockJob::get_blocked_jobids_for_primary_user($me);
        $newitems = [];
        foreach($items as $item){
        	if(!in_array($item->id,$jobids)){
        		$newitems[] = $item;
        	}
        }
        $items = $newitems;
        // ------------------------------------------------------------------

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
    	BlockJob::block_job($me,$reportedjobid);
    	return $this->respondWithStatus(true);
    }


}
