<?php namespace App\Http\Requests\Web;

use App\Http\Requests\ApiRequest;

class NudgeRequest extends ApiRequest {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{

		return [
			'job_id' => 'required',
			'phone' => 'required',
			'name' => 'required',
			'message' => 'required',
		];
	}

}
