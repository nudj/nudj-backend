<?php namespace App\Http\Requests;


use Illuminate\Support\Facades\Config;

class VerifyUserRequest extends ApiRequest {


	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'phone' => 'required',
			'verification' => 'required|size:' . Config::get('cfg.verification_code_length')
		];
	}


}
