<?php namespace App\Http\Requests;

class CreateJobRequest extends ApiRequest {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'title'           => 'required',
			'description'     => 'required',
			'bonus'           => 'required',
			'salary_amount'   => 'required',
			'salary_currency' => 'required',
			'bonus'           => 'required',
			'bonus_currency'  => 'required',
			'skills'          => 'required',
		];
	}

}
