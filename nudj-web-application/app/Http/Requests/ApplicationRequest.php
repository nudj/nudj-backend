<?php namespace App\Http\Requests;

class ApplicationRequest extends ApiRequest {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [

		];
	}

}
