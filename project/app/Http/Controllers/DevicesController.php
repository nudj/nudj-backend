<?php namespace App\Http\Controllers;

use App\Events\LoginUserEvent;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Models\Device;
use App\Models\User;
use App\Http\Requests;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Transformers\ContactTransformer;
use App\Utility\Transformers\JobTransformer;
use App\Utility\Transformers\SkillTransformer;
use App\Utility\Transformers\UserTransformer;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;


class DevicesController extends ApiController
{



    public function register(RegisterDeviceRequest $request)
    {
        $device = Device::add($this->authenticator->getUserId(), $request->all());

        return $this->respondWithStatus($device->id);
    }





}
