<?php namespace App\Http\Requests;

class ApplyRequest extends ApiRequest {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
            'nameInput'     => 'required',
            'emailInput'    => 'required',
            'linkInput'     => 'required',
            'referrerInput' => 'required'
		];
	}

}
