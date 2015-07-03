<?php namespace App\Http\Requests;



class NudgeRequest extends ApiRequest {


	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		return [
			'hash' => 'required',
			'contact' => 'required',
		];
	}


}
