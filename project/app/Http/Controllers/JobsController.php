<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Models\Job;
use App\Http\Requests;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Token;
use App\Utility\Transformers\JobTransformer;
use Illuminate\Support\Facades\Input;


class JobsController extends ApiController {


	public function index()
	{
		$items = Job::api()->paginate($this->limit);

		return $this->respondWithPagination($items, new JobTransformer());
	}


	public function show($id)
	{

		$item = Job::api()->find($id);

		if(!$item)
			throw new ApiException(ApiExceptionType::$NOT_FOUND);

		return $this->respondWithItem($item, new JobTransformer());
	}


	public function store(CreateJobRequest $request)
	{
		$job = Job::add($this->authenticator->getUserId(), $request->all());

		return $this->respondWithStatus($job->id);
	}


	public function update($id)
	{
		$job = Job::findIfOwnedBy($id, $this->authenticator->getUserId());

		if(!$job)
			throw new ApiException(ApiExceptionType::$NOT_FOUND);

		$status = $job->edit(Input::all());

		return $this->respondWithStatus($status);
	}


	public function destroy($id)
	{
		$job = Job::findIfOwnedBy($id, $this->authenticator->getUserId());

		if(!$job)
			throw new ApiException(ApiExceptionType::$NOT_FOUND);

		$status = $job->delete();

		return $this->respondWithStatus($status);
	}


	public function like($id)
	{
		return $this->respondWithStatus(Job::like($id, $this->authenticator->getUserId()));
	}

	public function unlike($id)
	{
		return $this->respondWithStatus(Job::like($id, $this->authenticator->getUserId(), true));
	}

}
