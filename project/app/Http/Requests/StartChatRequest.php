<?php namespace App\Http\Requests;



class StartChatRequest extends ApiRequest {


	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		return [
			'job_id' => 'required',
			'notification_id' => 'required',
			'user_id' => 'required',
			'message' => 'required',
		];
	}


}
