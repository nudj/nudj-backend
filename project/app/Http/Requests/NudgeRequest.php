<?php namespace App\Http\Requests;

class NudgeRequest extends ApiRequest {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'job' => 'required',
			'contacts' => 'required',
		];
	}

}
