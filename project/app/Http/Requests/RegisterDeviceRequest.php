<?php namespace App\Http\Requests;

class RegisterDeviceRequest extends ApiRequest {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'token' => 'required'
		];
	}

}
