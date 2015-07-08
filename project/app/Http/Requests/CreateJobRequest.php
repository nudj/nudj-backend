<?php namespace App\Http\Requests;



class CreateJobRequest extends ApiRequest {


	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		return [
			'title' => 'required',
			'description' => 'required',
			'bonus' => 'required',
			'salary' => 'required',
			'skills' => 'required',
		];
	}


}
