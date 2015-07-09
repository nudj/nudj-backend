<?php namespace App\Http\Requests;



class CreateUserRequest extends ApiRequest {


	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		return [
			'phone' => 'required',
			'country_code' => 'required'
		];
	}


}
