<?php namespace App\Http\Requests\Web;


use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest {


	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'phone' => 'required',
			'type' => 'required',
			'country_id' => 'required',
		];
	}


}
