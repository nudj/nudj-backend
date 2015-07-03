<?php namespace App\Http\Controllers;


use App\Http\Requests\AskForReferralsRequest;
use App\Http\Requests\NudgeRequest;
use App\Models\Nudge;
use App\Models\Referral;

class NudgeController extends ApiController {


	public function ask(AskForReferralsRequest $request)
	{

		Referral::askContactsToReffer($request->job, $request->contacts);

		$this->respondWithStatus(true);
	}

	public function nudge(NudgeRequest $request)
	{
		Nudge::addNewNudge($request->hash, $request->contact);

		$this->respondWithStatus(true);
	}



}
