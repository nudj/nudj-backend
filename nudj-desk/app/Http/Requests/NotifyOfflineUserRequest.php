<?php namespace App\Http\Requests;

class NotifyOfflineUserRequest extends ApiRequest {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'message' => 'required',
			'chat_id' => 'required',
			'user_id' => 'required',
		];
	}

}
