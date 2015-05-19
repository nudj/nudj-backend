<?php namespace App\Http\Requests;



class CreateJobRequest extends Request {


	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		return [
			'title' => 'required',
			'description' => 'required',
		];
	}


}
