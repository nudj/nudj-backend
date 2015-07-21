<?php namespace App\Http\Controllers;


use App\Http\Requests\AskForReferralsRequest;
use App\Http\Requests\NudgeRequest;
use App\Models\Nudge;
use App\Models\Referral;
use App\Utility\Facades\Shield;

class NudgeController extends ApiController {


	public function ask(AskForReferralsRequest $request)
	{
		$referral = new Referral();
		$referral->askContactsToReffer(Shield::getUserId(), $request->job, $request->contacts, $request->message);

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
