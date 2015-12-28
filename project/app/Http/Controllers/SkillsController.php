<?php namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests;
use App\Models\Skill;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Transformers\ContactTransformer;
use App\Utility\Transformers\SkillTransformer;
use Illuminate\Support\Facades\Input;

class SkillsController extends ApiController
{

    public function suggest($term = null)
    {
        if(!$term)
            throw new ApiException(ApiExceptionType::$INVALID_INPUT);

        $skill = new Skill();
        $suggestions = $skill->suggest($term);

        return $this->returnResponse(['data' => $suggestions]);
    }

}
