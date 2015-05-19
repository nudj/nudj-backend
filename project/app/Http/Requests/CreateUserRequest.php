<?php namespace App\Http\Requests;



class CreateUserRequest extends Request {


	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		return [
			'phone' => 'required'
		];
	}


}
