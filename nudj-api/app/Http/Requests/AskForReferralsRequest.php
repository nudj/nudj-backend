<?php namespace App\Http\Requests;

class AskForReferralsRequest extends ApiRequest {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'job' => 'required'
		];
	}

}
