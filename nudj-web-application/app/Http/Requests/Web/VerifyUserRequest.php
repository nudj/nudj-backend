<?php namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Validator;

class VerifyUserRequest extends FormRequest {

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

	protected function failedValidation(Validator $validator)
	{
		die(json_encode($this->formatErrors($validator)));
	}

}
