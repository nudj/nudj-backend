<?php namespace App\Http\Controllers;


use App\Http\Requests\ApplyRequest;
use App\Http\Requests\AskForReferralsRequest;
use App\Http\Requests\NudgeRequest;
use App\Models\Nudge;
use App\Models\Referral;
use App\Utility\Facades\Shield;

class NudgeController extends ApiController {


	public function ask(AskForReferralsRequest $request)
	{
		Referral::askContacts(Shield::getUserId(), $request->job, $request->contacts, $request->message);

		return $this->respondWithStatus(true);
	}

	public function nudge(NudgeRequest $request)
	{
		Nudge::nudgeContacts(Shield::getUserId(), $request->job, $request->contacts, $request->message);

		return $this->respondWithStatus(true);
	}


	public function apply(ApplyRequest $request)
	{
		Nudge::applyForJob(Shield::getUserId(), $request->job_id);
	}


}
