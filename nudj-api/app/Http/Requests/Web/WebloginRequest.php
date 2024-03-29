<?php namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Validator;

class WebLoginRequest extends FormRequest {

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

}
