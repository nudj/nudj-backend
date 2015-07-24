<?php namespace App\Http\Requests\Web;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Validator;

class WebloginRequest extends FormRequest {


	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'phone' => 'required',
			'name' => 'required',
			'country_code' => 'required|size:2',
		];
	}


	protected function failedValidation(Validator $validator)
	{
		die(json_encode($this->formatErrors($validator)));
	}


}
