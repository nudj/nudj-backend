<?php namespace App\Http\Controllers;


use App\Http\Requests\AskForReferralsRequest;
use App\Http\Requests\NudgeRequest;
use App\Models\Nudge;
use App\Models\Referral;

class NudgeController extends ApiController {


	public function ask(AskForReferralsRequest $request)
	{
		$referral = new Referral();
		$referral->askContactsToReffer($request->job, $request->contacts);

		return $this->respondWithStatus(true);
	}

	public function nudge(NudgeRequest $request)
	{
		$nudge = new Nudge();
		$nudge->addNewNudge($request->hash, $request->contact);

		return $this->respondWithStatus(true);
	}


	public function apply()
	{
		//@TODO
	}


}
